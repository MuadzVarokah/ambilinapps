<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Kat_user extends Model
{
    use HasFactory;
    protected $table = 'uns_kat_user';
    protected $guarded = ['id'];
    public $timestamps = false;
}