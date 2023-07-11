<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class WP_Lokasi extends Model
{
    use HasFactory;
    protected $table = 'wp_lokasi';
    protected $guarded = ['id'];
    public $timestamps = false;
}