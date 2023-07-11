<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Hapus_Akun extends Model
{
    use HasFactory;
    protected $table = 'uns_deleted_user';
    protected $guarded = ['id'];
    public $timestamps = false;
}