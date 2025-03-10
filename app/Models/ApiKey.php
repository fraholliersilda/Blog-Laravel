<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;


class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'user_id',
        'expires_at',
        'last_used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateKey()
    {
        return 'api_' . Str::random(60);
    }

    public function isValid()
    {
        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }
        return true;
    }

    public function markAsUsed()
    {
        $this->update([
            'last_used_at' => now(),
        ]);
    }
}
