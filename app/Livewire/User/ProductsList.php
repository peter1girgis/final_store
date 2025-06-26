<?php

namespace App\Livewire\User;

use App\Models\CartItem;
use App\Models\categories;
use App\Models\payments;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;
    public $state = [];
    public $selected_categories = [];

    public $all_categories = [];
    public $topRatedProducts = [];

    protected $paginationTheme = 'bootstrap';
    public function addToCart()
    {
        $userId = Auth::id();

        if (!$userId) {
            session()->flash('message', ['type' => 'warning', 'text' => 'Please log in to add products to cart']);
            return;
        }

        $item = CartItem::where('user_id', $userId)
                        ->where('product_id', $this->state['id'])
                        ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $this->state['id'],
                'quantity' => 1,
            ]);
        }
        session()->flash('message', ['type' => 'success', 'text' => 'Product added to cart']);
    }

    public function view_item(Product $item){
        $this->state = [];
		$this->state  = $item->toArray();
        $this->all_categories = categories::select('id', 'name')->get();
        $this->selected_categories = $item->categories->pluck('id')->toArray();
        $this->state['sub_images'] = json_decode($item->sub_images, true);


		// $this->showEditModal = false;

		$this->dispatch('show_product');
    }


    // #[On('open-seller-request')]
    // public function openForm()
    // {

    //     $this->dispatch('show_form_request_seller');
    // }

    public function render()
    {
        $topProducts = payments::select('product_id', \DB::raw('SUM(total_quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();

        $productIds = $topProducts->pluck('product_id')->toArray();

        $productsMap = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $topSellingProducts = collect($productIds)->map(fn($id) => $productsMap[$id])->filter();

        $products = Product::latest()->paginate(8);
        $this->all_categories = categories::select('id', 'name','image')->get();
        $this->topRatedProducts = Product::with('store')
            ->withAvg('evaluations', 'rating')
            ->orderByDesc('evaluations_avg_rating')
            ->take(9)
            ->get();
        return view('livewire.user.products-list',
        ['products' => $products , 'categories' =>  $this->all_categories ,'topRatedProducts' => $this->topRatedProducts , 'topSellingProducts' => $topSellingProducts])
        ->layout('layouts.user_layout');
    }
}
