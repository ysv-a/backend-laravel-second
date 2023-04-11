<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\User;
use App\Policies\BookPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Book::class => BookPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        Gate::define('update-book', function (User $user, Book $book) {
            return $user->id === $book->user_id;
        });

    }
}
