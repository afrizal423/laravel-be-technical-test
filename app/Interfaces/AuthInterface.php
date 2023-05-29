<?php
namespace App\Interfaces;

use App\Http\Requests\Auth\UserLoginRequest;
use Illuminate\Database\Eloquent\Collection;

interface AuthInterface
{

    public function cekLogin(array $data): bool;

    public function register(array $data);
}
