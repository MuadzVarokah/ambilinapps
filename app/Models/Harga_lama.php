<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Harga_lama extends Model
{
    use HasFactory;
    protected $table = 'uns_harga_lama';
    protected $guarded = ['id'];
    public $timestamps = false;
}