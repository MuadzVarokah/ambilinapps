<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Alasan_lokasi extends Model
{
    use HasFactory;
    protected $table = 'uns_alasan_lokasi';
    protected $guarded = ['id'];
    public $timestamps = false;
}