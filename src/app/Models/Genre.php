<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // Mass-assignable attributes
    protected $fillable = [
        'name',
    ];

    // Relationships
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
