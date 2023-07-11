<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Lokasi_jenis extends Model
{
    use HasFactory;
    protected $table = 'wp_lokasijenis';
    protected $guarded = ['id'];
    public $timestamps = false;
}