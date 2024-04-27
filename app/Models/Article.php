<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    function author() {
        return $this->belongsTo(Author::class);
    }

    function subscribers() {
        return $this->belongsToMany(User::class, (new Subscription)->getTable(), 'author_id', 'user_id');
    }
    
}
