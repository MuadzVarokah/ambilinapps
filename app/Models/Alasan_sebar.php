<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Alasan_sebar extends Model
{
    use HasFactory;
    protected $table = 'uns_alasan_sebar';
    protected $guarded = ['id'];
    public $timestamps = false;
}