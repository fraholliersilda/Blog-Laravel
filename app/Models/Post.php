<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    public function media()
    {
        return $this->hasOne(Media::class)->where('photo_type', 'cover');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
