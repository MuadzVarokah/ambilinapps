<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Forgot extends Model
{
    use HasFactory;
    protected $table = 'uns_lupa_password';
    protected $guarded = ['id'];
    // public $timestamps = false;
}