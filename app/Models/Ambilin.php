<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Ambilin extends Model
{
    use HasFactory;
    protected $table = 'ambilin';
    protected $guarded = ['id'];
    public $timestamps = false;
}