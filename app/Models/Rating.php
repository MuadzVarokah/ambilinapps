<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Rating extends Model
{
    use HasFactory;
    protected $table = 'uns_rating';
    protected $guarded = ['id'];
    public $timestamps = false;
}