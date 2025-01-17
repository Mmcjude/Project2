<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model implements \JsonSerializable
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

    // JSON serialization for API responses
    public function jsonSerialize(): mixed
    {
        return [
            'id' => intval($this->id),
            'name' => $this->name,
            'description' => $this->description,
            'author' => $this->author->name, // Accessing the name of the related author
            'genre' => $this->genre->name,   // Accessing the name of the related genre
            'price' => number_format($this->price, 2),
            'year' => intval($this->year),
            'image' => asset('images/' . $this->image), // Correct image URL
        ];
    }
}
