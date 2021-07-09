<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['key', 'name', 'description', 'group'];

    public function getRouteKeyName()
    {
        return 'key';
    }
}