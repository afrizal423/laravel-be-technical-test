<?php

namespace App\Providers;

use App\Interfaces\AuthInterface;
use App\Repository\NewsRepository;
use App\Repository\CommentRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\NewsRepositoryInterface;
use App\Interfaces\CommentRepositoryInterface;
use App\Repository\AuthRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            NewsRepositoryInterface::class,
            NewsRepository::class);
        $this->app->bind(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );
        $this->app->bind(
            AuthInterface::class,
            AuthRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
