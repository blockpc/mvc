<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['key', 'name', 'description'];

    public function getRouteKeyName()
    {
        return 'key';
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeRoles($query)
    {
        return ( auth()->role_id == 1 ) ? $query : $query->where('id', '>', 1);
    }
}