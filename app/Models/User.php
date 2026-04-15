<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\FormatDates;
use App\Enums\RoleEnum;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, Impersonate, FormatDates;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!empty($this->deleted_at)) {
                    return (object) [
                        'class' => 'danger',
                        'msg' => 'Tidak Aktif',
                    ];
                } else {
                    return (object) [
                        'class' => 'primary',
                        'msg' => 'Aktif',
                    ];
                }
            }
        );
    }
}
