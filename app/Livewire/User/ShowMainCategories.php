<?php

namespace App\Livewire\User;

use App\Models\Categories;
use App\Models\MainCategories;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ShowMainCategories extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $mainCategoryId;
    public $mainCategory;
    public $categories; // كائنات الفئات
    public $categoryIds = []; // معرفات الفئات

    public function mount($mainCategoryId)
    {
        $this->mainCategoryId = $mainCategoryId;

        // جلب بيانات التصنيف الرئيسي
        $this->mainCategory = MainCategories::findOrFail($mainCategoryId);

        // جلب الفئات المرتبطة به
        $this->categories = Categories::where('main_category_id', $mainCategoryId)->get();

        // حفظ المعرفات في مصفوفة لاستخدامها لاحقًا
        $this->categoryIds = $this->categories->pluck('id')->toArray();
    }

    public function render()
    {
        // المنتجات التابعة للفئات المرتبطة بهذا التصنيف
        $products = Product::whereHas('categories', function ($query) {
                                $query->whereIn('categories.id', $this->categoryIds);
                            })
                            ->with('categories')
                            ->latest()
                            ->paginate(6);

        // الأعلى تقييماً
        $topRatedProducts = Product::withAvg('evaluations', 'rating')
                            ->whereHas('categories', function ($query) {
                                $query->whereIn('categories.id', $this->categoryIds);
                            })
                            ->orderByDesc('evaluations_avg_rating')
                            ->take(6)
                            ->get();

        // الأكثر مبيعًا (يعتمد على جدول payments)
        $topSellingProducts = Product::withCount('payments')
                            ->whereHas('categories', function ($query) {
                                $query->whereIn('categories.id', $this->categoryIds);
                            })
                            ->orderByDesc('payments_count')
                            ->take(6)
                            ->get();

        return view('livewire.user.show-main-categories', [
            'products' => $products,
            'topRatedProducts' => $topRatedProducts,
            'topSellingProducts' => $topSellingProducts,
            'categories' => $this->categories,
            'mainCategory' => $this->mainCategory,
        ])->layout('layouts.user_layout');
    }
}
