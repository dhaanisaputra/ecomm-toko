<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\helper\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;

#[Title('Products Pages - Ecomm Toko')]
class ProductsPages extends Component
{
    use WithPagination;
    use LivewireAlert;

    #[Url]
    public $selectedCategories = [];

    #[Url]
    public $selectedBrands = [];

    #[Url]
    public $featured;

    #[Url]
    public $on_sale;

    #[Url]
    public $price_range = 20000000;

    #[Url]
    public $sort = 'latest';

    // add item to cart method
    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product Added to Cart Successfully!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        // this for filter by selected category
        $productQuery = Product::query()->where('is_active', 1);
        if (!empty($this->selectedCategories)) {
            $productQuery->whereIn('category_id', $this->selectedCategories);
        }
        // this for filter by selected brand
        if (!empty($this->selectedBrands)) {
            $productQuery->whereIn('brand_id', $this->selectedBrands);
        }
        // this for filter by selected featured
        if ($this->featured) {
            $productQuery->where('is_featured', 1);
        }
        // this for filter by selected on_sale
        if ($this->on_sale) {
            $productQuery->where('on_sale', 1);
        }
        // this for filter by range price
        if ($this->price_range) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }
        // this for filter by sort latest product
        if ($this->sort == 'latest') {
            $productQuery->latest();
        }
        // this for filter by sort price product
        if ($this->sort == 'price') {
            $productQuery->orderBy('price');
        }

        return view('livewire.products-pages', [
            'products' => $productQuery->paginate(9),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
