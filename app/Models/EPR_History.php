<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class EPR_History extends Model
{
    use HasFactory;
    protected $table = 'uns_epr_history';
    protected $guarded = ['id'];
    public $timestamps = false;
}