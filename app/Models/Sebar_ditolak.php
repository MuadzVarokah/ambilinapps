<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Sebar_ditolak extends Model
{
    use HasFactory;
    protected $table = 'uns_sebar_ditolak';
    protected $guarded = ['id'];
    public $timestamps = false;
}