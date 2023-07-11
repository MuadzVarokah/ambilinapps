<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Waste_date extends Model
{
    use HasFactory;
    protected $table = 'waste_date';
    protected $guarded = ['id'];
    public $timestamps = false;
}