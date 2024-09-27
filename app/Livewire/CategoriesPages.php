<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Title;

#[Title('Categories Pages - Ecomm Toko')]
class CategoriesPages extends Component
{
    public function render()
    {
        $categoires = Category::where('is_active', 1)->get();
        return view('livewire.categories-pages', [
            'categories' => $categoires,
        ]);
    }
}
