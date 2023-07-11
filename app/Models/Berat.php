<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Berat extends Model
{
    use HasFactory;
    protected $table = 'uns_berat';
    protected $guarded = ['id'];
    public $timestamps = false;
}