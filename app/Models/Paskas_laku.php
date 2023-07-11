<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Paskas_laku extends Model
{
    use HasFactory;
    protected $table = 'uns_paskas_laku';
    protected $guarded = ['id'];
    public $timestamps = false;
}