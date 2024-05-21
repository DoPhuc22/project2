<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    protected $table = 'ages';
    protected $fillable = ['name', 'created_at', 'updated_at'];
    use HasFactory;
}
