<?php

namespace App\Users;

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\Users\UserFactory> */
    use HasFactory ,Notifiable, SoftDeletes;


protected $table = 'users';
protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'status',
];

protected $hidden = [
    'password',
    'updated_at',
    'created_at',
    'deleted_at',
];

protected function casts(): array
{
    return [
        'role' => UserRoles::class,
        'status' => UserStatus::class,
        'password' => 'hashed',
    ];
}
 public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


}
