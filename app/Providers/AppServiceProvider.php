<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Gate::define('test',function(User $user){
            if($user->id === 1) {
                return true;
            }
            return false;
       });

       Gate::define('edit-post',function(User $user, Post $post){
        if($user->id === $post->user_id){
            return true;
        }
        return false;
       });
    }
    public const HOME = '/post';
}
