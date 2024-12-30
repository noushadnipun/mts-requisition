<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'employee_no', 'username', 'role', 'birthday', 'gender', 'marital_status', 'father', 'mother', 'address',
        'district', 'postcode', 'phone', 'emergency_phone', 'company', 'department', 'designation', 'join_date', 'company_address', 'basic_salary', 'avatar',
        'signature', 'bank_information', 'mbanking_information', 'alternative_email', 'employee_status', 'employee_status_reason', 'is_active', 'email_verified_at',
        'password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token','secret_token', 'current_team_id', 'profile_photo_path', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($userid, $role)
    {
        return $this->where('role', $role)->where('id', $userid)->first();
    }

    public function isAdmin($userid)
    {
        return $this->where('role', 1)->where('id', $userid)->first();
    }

    public function isResource($userid)
    {
        return $this->where('role', 2)->where('id', $userid)->first();
    }

    public function isManager($userid)
    {
        return $this->where('role', 3)->where('id', $userid)->first();
    }

    public function isCFO($userid)
    {
        return $this->where('role', 4)->where('id', $userid)->first();
    }

    public function isAccountant($userid)
    {
        return $this->where('role', 5)->where('id', $userid)->first();
    }

    public function isMember($userid)
    {
        return $this->where('role', 6)->where('id', $userid)->first();
    }

    public function isHR($userid)
    {
        return $this->where('role', 7)->where('id', $userid)->first();
    }

    public function isApprover($userid)
    {
        return $this->where('role', 8)->where('id', $userid)->first();
    }
  


}
