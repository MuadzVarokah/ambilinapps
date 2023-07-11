<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Poin_usage extends Model
{
    use HasFactory;
    protected $table = 'uns_poin_usage';
    protected $guarded = ['id'];
    public $timestamps = false;
}