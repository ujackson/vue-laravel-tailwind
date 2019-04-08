<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = ['id'];
    /**
     * Get all of the owning rateable models.
     */
    public function rateable()
    {
        return $this->morphTo();
    }
    /**
     * Get rater.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
