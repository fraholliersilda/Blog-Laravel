<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }


    public function hasOneOfRoles(...$roles): bool
    {
        return in_array($this->role?->name, $roles, true);
    }

    // public function media()
    // {
    //     return $this->hasMany(Media::class);
    // }

    // public function posts()
    // {
    //     return $this->hasManyThrough(Post::class, Media::class, 'user_id', 'id', 'id', 'post_id');
    // }

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }
}
