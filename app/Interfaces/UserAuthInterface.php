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
    public function login(UserLoginRequest $request);

    public function registerAdmin(UserRegisterRequest $request);

    public function registerMember(UserRegisterRequest $request);

    public function logout(Request $request);

}
