<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'firstname', 'lastname', 'user_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['fullName'];

    /**
     * Get the fullname attribute for user or username by defult.
     *
     * @return bool
     */
    public function getFullNameAttribute()
    {
        return ($this->firstname || $this->lastname) ? trim("{$this->firstname} {$this->lastname}") : null;
    }

    // one profile belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get image User. Polimorph Relation
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
