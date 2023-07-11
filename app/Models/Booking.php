<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Booking extends Model
{
    use HasFactory;
    protected $table = 'uns_ambilin_booking';
    protected $guarded = ['id'];
    public $timestamps = false;
}