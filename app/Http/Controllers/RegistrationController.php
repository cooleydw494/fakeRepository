<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegistrationForm;
use App\User;
use App\Mail\WelcomeMail;

class RegistrationController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest');
    }

    public function create()
    {
      return view('registration.create');
    }

    public function store(RegistrationForm $form)
    {
      //persist the user in DB
      $form->persist();
      //put message in session
      session()->flash('message', 'Thanks so much for signing up!');
      //redirect
      return redirect(route('home'));
    }
}
