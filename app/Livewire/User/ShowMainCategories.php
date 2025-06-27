<?php

namespace App\Livewire\User;

use App\Models\CartItem;
use App\Models\Categories;
use App\Models\MainCategories;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ShowMainCategories extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $mainCategoryId;
    public $mainCategory;
    public $categories; // الكائنات
    public $categoryIds = [];
    public $state = [];
    public $selected_categories = [];
    public $all_categories = []; // معرفات كل الفئات
    public $selectedCategories = []; // الفئات المختارة يدويًا

    public function mount($mainCategoryId)
    {
        $this->mainCategoryId = $mainCategoryId;

        // جلب بيانات التصنيف الرئيسي
        $this->mainCategory = MainCategories::findOrFail($mainCategoryId);

        // الفئات التابعة
        $this->categories = Categories::where('main_category_id', $mainCategoryId)->get();

        // حفظ كل المعرفات لاستخدامها كقيمة افتراضية
        $this->categoryIds = $this->categories->pluck('id')->toArray();
    }
    public function view_item(Product $item){
        $this->state = [];
		$this->state  = $item->toArray();
        $this->all_categories = categories::select('id', 'name')->get();
        $this->selected_categories = $item->categories->pluck('id')->toArray();
        $this->state['sub_images'] = is_string($item->sub_images)
        ? json_decode($item->sub_images, true)
        : $item->sub_images;



		// $this->showEditModal = false;

		$this->dispatch('show_product');
    }
    public function addToCart()
{
    $userId = Auth::id();

    if (!$userId) {
        session()->flash('message', ['type' => 'warning', 'text' => 'Please log in to add products to cart']);
        return;
    }

    // تحميل المنتج الحالي باستخدام الـ ID
    $product = Product::find($this->state['id']);

    if (!$product) {
        $this->dispatch('return_operation_stopped');
        return;
    }

    $item = CartItem::where('user_id', $userId)
                    ->where('product_id', $product->id)
                    ->first();

    if ($item) {
        // التحقق إذا كانت الكمية الجديدة لا تتجاوز المخزون
        if ($item->quantity + 1 > $product->stock) {
            $this->dispatch('return_operation_stopped');
            return;
        }

        $item->increment('quantity');
    } else {
        // التحقق إذا كان هناك مخزون كافي قبل الإضافة
        if ($product->stock < 1) {
            $this->dispatch('return_operation_stopped');
            return;
        }

        CartItem::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    $this->dispatch('return_success');
}

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            // احذف لو موجود
            $this->selectedCategories = array_filter($this->selectedCategories, fn($id) => $id != $categoryId);
        } else {
            // أضف لو مش موجود
            $this->selectedCategories[] = $categoryId;
        }

        $this->resetPage(); // لإعادة ضبط الـ pagination عند تغيير الفئات
    }

    public function render()
    {
        // لو في فئات مختارة نستخدمها، لو لأ نستخدم كل الفئات المرتبطة بالتصنيف
        $filterCategories = count($this->selectedCategories) > 0 ? $this->selectedCategories : $this->categoryIds;

        $products = Product::whereHas('categories', function ($query) use ($filterCategories) {
                                $query->whereIn('categories.id', $filterCategories);
                            })
                            ->with('categories')
                            ->latest()
                            ->paginate(6);

        $topRatedProducts = Product::withAvg('evaluations', 'rating')
                            ->whereHas('categories', function ($query) use ($filterCategories) {
                                $query->whereIn('categories.id', $filterCategories);
                            })
                            ->orderByDesc('evaluations_avg_rating')
                            ->take(6)
                            ->get();

        $topProducts = \DB::table('payments')
            ->select('payments.product_id', \DB::raw('SUM(total_quantity) as total_sales'))
            ->join('categories_product', 'payments.product_id', '=', 'categories_product.product_id')
            ->whereIn('categories_product.categories_id', $filterCategories)
            ->groupBy('payments.product_id')
            ->orderByDesc('total_sales')
            ->limit(6)
            ->get();

        $productIds = $topProducts->pluck('product_id')->toArray();

        $productsMap = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $topSellingProducts = collect($productIds)->map(fn($id) => $productsMap[$id])->filter();



        return view('livewire.user.show-main-categories', [
            'products' => $products,
            'topRatedProducts' => $topRatedProducts,
            'topSellingProducts' => $topSellingProducts,
            'categories' => $this->categories,
            'mainCategory' => $this->mainCategory,
            'selectedCategories' => $this->selectedCategories,
        ])->layout('layouts.user_layout');
    }
}
