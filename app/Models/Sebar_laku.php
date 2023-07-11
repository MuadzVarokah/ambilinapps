<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Sebar_laku extends Model
{
    use HasFactory;
    protected $table = 'uns_sebar_laku';
    protected $guarded = ['id'];
    public $timestamps = false;
}