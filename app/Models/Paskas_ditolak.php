<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Paskas_ditolak extends Model
{
    use HasFactory;
    protected $table = 'uns_paskas_ditolak';
    protected $guarded = ['id'];
    public $timestamps = false;
}