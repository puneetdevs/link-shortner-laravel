<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id', 'destination', 'slug', 'views'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'short_url'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full shortened URL as an attribute.
     *
     * @return string
     */
    public function getShortUrlAttribute()
    {
        return url('/') . '/' . $this->slug;
    }

}
