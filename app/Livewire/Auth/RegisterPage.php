<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

#[Title('Register Page -Tech Soko Kenya ')]

class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    //register user
    public function save(){
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|max:255',

        ]);

        // save to db
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        //login here
        auth()->login($user);

        //redirect to home page
        return redirect()->intended();

    }


    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
