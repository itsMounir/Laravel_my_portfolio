<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['category','author'];
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public function category()
    {
        return $this->BelongsTo(Category::class);
    }

    public function author()
    {
        return $this->BelongsTo(User::class,'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query,array $filters)
    {
        if($filters['search'] ?? false) {
            $query
            ->where(fn($query)=>
            $query
            ->where('title','like','%'.request('search').'%')
            ->orWhere('body','like','%'.request('search').'%')
            ->orWhere('exerpts','like','%'.request('search').'%') );
        }

        $query->when($filters['category'] ?? false,fn($query,$category) =>
            $query
                ->whereHas('category',fn($query)=>
                $query->where('slug',$category)
             )
        );

        $query->when($filters['author'] ?? false,fn($query,$author) =>
            $query
                ->whereHas('author',fn($query)=>
                $query->where('name',$author)
             )
        );
    }
}

