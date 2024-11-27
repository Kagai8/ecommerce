<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use App\Models\User;

#[Title('Forget Password Page -Tech Soko Kenya ')]

class ForgetPasswordPage extends Component
{
    public $email;

    public function save(){
        $this->validate([
            'email' => 'required|email|max:255|exists:users,email',
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password reset link has been to sent your email address');
            $this->email = '';
        }
    }

    public function render()
    {
        return view('livewire.auth.forget-password-page');
    }
}
