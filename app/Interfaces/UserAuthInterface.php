<?php
namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;

interface UserAuthInterface
{
    /**
     * Function untuk login admin maupun member
     *
     * @param Request $request
     * @return void
     */
    /**
     * lebih ramping lagi jika memakai konsep
     * Open/Closed Principle (OCP), Liskov Substitution Principle (LSP)
     * jadi hanya tinggal login, register, logout
     * pada setiap controller auth disetiap role
     * lalu tinggal di implements
     */
    public function login(UserLoginRequest $request);

    public function register(UserRegisterRequest $request);

    public function logout(Request $request);

}
