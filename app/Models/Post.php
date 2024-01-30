<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;



class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    protected $fillable = [
        'user_id',
        'posts',
        'created_at',
        'update_at'
    ];

    public function user(){
        return $this->belongsTo(User::class); 

    }
}
