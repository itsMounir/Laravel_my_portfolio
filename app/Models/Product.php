<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    //protected $fillable = ['name','role','moobile_phone','password'];

    public function scopeFilter($query,array $filters)
    {
        if($filters['search'] ?? false) {
            $query
            ->where(fn($query)=>
            $query
            ->where('s_name','like','%'.request('search').'%'));
        }

        $query->when($filters['category'] ?? false,fn($query,$category)
        => $query->where('category_id',$category)
    );
    }

    public function storehouse(){
        return $this->belongsTo(Storehouse::class);
    }

    public function category()
    {
        return $this->BelongsTo(Category::class);
    }

    public function order_products(){
        return $this->hasMany(OrderProduct::class);
    }
}
