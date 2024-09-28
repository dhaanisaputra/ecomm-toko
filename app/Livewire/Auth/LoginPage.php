<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Login')]
class LoginPage extends Component
{
    public $email;
    public $password;

    // login user
    public function save()
    {
        $this->validate([
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|min:6|max:255',
        ]);

        if (!auth()->guard('web')->attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', 'Invalid email or password');
            return;
        }
        // auth()->guard('web')->login($this->email, $this->password);

        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
