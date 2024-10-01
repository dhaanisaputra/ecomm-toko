<?php

namespace App\Livewire;

use Livewire\Component;
use App\helper\CartManagement;
use App\Models\Address;
use App\Models\Order;
use Livewire\Attributes\Title;

#[Title('Checkout')]
class CheckoutPages extends Component
{

    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;

    public function placeOrder()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);
        $cart_items = CartManagement::getCartItemsFromCookie();
        $line_items = [];

        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'idr',
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                    ]
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $order = new Order();
        $order->user_id = auth()->guard('web')->user()->id;
        $order->grand_total = CartManagement::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'idr';
        $order->shipping_total = 0;
        $order->shipping_method = 'none';
        $order->notes = 'Order placed by ' . auth()->guard('web')->user()->name;

        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->street_address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip_code;

        $redirect_url = '';

        if ($this->payment_method == 'cash' || $this->payment_method == 'cod') {
            if ($this->payment_method == 'cash') {
                $order->payment_status = 'paid';
            }
            $redirect_url = route('success');
        } else {
            // this condition must integrate with the payment gateway
        }

        $order->save();
        $address->order_id = $order->id;
        $address->save();

        $order->items()->createMany($cart_items);
        CartManagement::clearCartItems();
        return redirect($redirect_url);

        // $grand_total = CartManagement::calculateGrandTotal($cart_items);
        // $this->emit('placeOrder', [
        //     'first_name' => $this->first_name,
        //     'last_name' => $this->last_name,
        //     'phone' => $this->phone,
        //     'street_address' => $this->street_address,
        //     'city' => $this->city,
        //     'state' => $this->state,
        //     'zip_code' => $this->zip_code,
        //     'payment_method' => $this->payment_method,
        //     'grand_total' => $grand_total,
        //     'cart_items' => $cart_items,
        // ]);
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);
        return view('livewire.checkout-pages', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total,
        ]);
    }
}
