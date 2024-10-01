<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('My Orders - Ecomm')]
class MyOrdersPages extends Component
{
    use WithPagination;

    public function render()
    {
        $my_orders = Order::where('user_id', auth()->guard('web')->user()->id)->latest()->paginate(5);
        return view('livewire.my-orders-pages', [
            'orders' => $my_orders,
        ]);
    }
}
