<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Paskas_foto extends Model
{
    use HasFactory;
    protected $table = 'uns_paskas_foto';
    protected $guarded = ['id'];
    public $timestamps = false;
}