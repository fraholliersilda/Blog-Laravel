<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = "media";

    protected $fillable = [
        'original_name',
        'hash_name',
        'path',
        'size',
        'extension',
        'photo_type',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
