<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'description'];

    public function media()
    {
        return $this->hasMany(Media::class, 'post_id');
    }
    // public function media()
    // {
    //     return $this->hasOne(Media::class);
    // }
    public function coverPhoto()
    {
        return $this->hasOne(Media::class, 'post_id')->where('photo_type', 'cover');
    }
    public function getCoverPhotoAttribute()
    {
        return $this->coverPhoto ? $this->coverPhoto->path : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
