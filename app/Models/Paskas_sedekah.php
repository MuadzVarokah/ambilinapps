<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Paskas_sedekah extends Model
{
    use HasFactory;
    protected $table = 'sebar';
    protected $guarded = ['id'];
    public $timestamps = false;
}