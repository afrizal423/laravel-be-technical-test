<?php
namespace App\Repository;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AuthRepository implements AuthInterface
{
    public function cekLogin(array $data): bool
    {
        return auth()->attempt($data);
    }

    public function register(array $data)
    {
        return User::create($data);
    }
}
