<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Success Checkout - Ecomm')]
class SuccessPages extends Component
{
    public function render()
    {
        // keep latest order
        $latest_order = Order::with('address')->where('user_id', auth()->guard('web')->user()->id)->latest()->first();
        return view(
            'livewire.success-pages',
            [
                'order' => $latest_order,
            ]
        );
    }
}
