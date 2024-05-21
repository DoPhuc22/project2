<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = 'wishLists';
    protected $fillable = ['movie_id', 'customer_id', 'created_at', 'updated_at'];
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
