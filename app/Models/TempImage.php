<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempImage extends Model
{
    protected $table = 'tempImages';
    protected $fillable = ['name', 'created_at', 'updated_at'];
    use HasFactory;
}
