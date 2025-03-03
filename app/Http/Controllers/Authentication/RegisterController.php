<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;

class RegisterController extends Controller
{

    public $registerService;
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function showRegister()
    {
        return view("auth.register");
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->registerService->createUser($validatedData);
        return redirect()->route('user.home')->with('success','Registration successful! Welcome,' . $user->name );
    }
}
