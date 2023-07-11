<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Notifikasi_Raw extends Model
{
    use HasFactory;
    protected $table = 'uns_notif_raw';
    protected $guarded = ['id'];
    public $timestamps = false;
}