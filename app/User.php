<?php

namespace App;

use App\Role;
use App\Rating;
use App\Traits\Uuid;
use Laravel\Passport\HasApiTokens;
use App\Notifications\VerifyEmailApi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The roles attached to a user
     * @return object
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Check user role
     * @param string $role
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->first();
    }

    /**
     * getAvatarAttribute
     * @param  string $value
     */
    public function getAvatarAttribute($value)
    {
        if ($value) {
            return Storage::disk('public')->url($value);
        } else {
            return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?s=400&d=mm";

        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailApi);
    }

    /**
     * Get all of the user's ratings.
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function sumRating()
    {
        return $this->ratings()->sum('rating');
    }

}
