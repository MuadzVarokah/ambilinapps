<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Sebar_foto extends Model
{
    use HasFactory;
    protected $table = 'uns_sebar_foto';
    protected $guarded = ['id'];
    public $timestamps = false;
}