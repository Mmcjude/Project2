<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Mass-assignable attributes
    protected $fillable = [
        'name', 'author_id', 'genre_id', 'description', 'year', 'price', 'image', 'display',
    ];

    // Relationships
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
