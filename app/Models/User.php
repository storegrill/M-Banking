<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'address', 'is_verified',
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
        'is_verified' => 'boolean',
    ];

    /**
     * Get the accounts associated with the user.
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Get the transactions associated with the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the multi-language settings for the user.
     */
    public function multiLanguage()
    {
        return $this->hasOne(MultiLanguage::class);
    }

    /**
     * Get the geolocation settings for the user.
     */
    public function geolocation()
    {
        return $this->hasOne(Geolocation::class);
    }

    /**
     * Get the investments associated with the user.
     */
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    /**
     * Get the mobile recharges associated with the user.
     */
    public function mobileRecharges()
    {
        return $this->hasMany(MobileRecharge::class);
    }

    /**
     * Get the virtual cards associated with the user.
     */
    public function virtualCards()
    {
        return $this->hasMany(VirtualCard::class);
    }

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function digitalWallet()
{
    return $this->hasOne(DigitalWallet::class);
}
}

