<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Room_Chat extends Model
{
    use HasFactory;
    protected $table = 'uns_room_chat';
    protected $guarded = ['id'];
    public $timestamps = false;
}