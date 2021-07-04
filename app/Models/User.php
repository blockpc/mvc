<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'email_verified_at', 'password', 'role_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
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
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];
    
    // Model Binding
    public function getRouteKeyName()
    {
        return 'name';
    }

    // mutador
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_BCRYPT);
    }

    // one user has one profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}