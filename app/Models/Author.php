<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    function articles() {
        return $this->hasMany(Article::class);
    }

    function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    function subscribers() {
        return $this->hasManyThrough(User::class, Subscription::class,'author_id','user_id');
    }
}
