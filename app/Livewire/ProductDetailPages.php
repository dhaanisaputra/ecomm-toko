<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Product Detail Pages - Ecomm Toko')]
class ProductDetailPages extends Component
{
    public $slug;
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.product-detail-pages', [
            'product' => Product::where('slug', $this->slug)->firstOrFail(),
        ]);
    }
}
