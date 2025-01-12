<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'bio']; // Add 'name' and 'bio' for mass assignment

    /**
     * Get the books associated with the author.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
