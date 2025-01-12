<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'author_id',
        'description',
        'price',
        'year',
        'genre_id',
    ];

    // Define the relationship to the Author model
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    // Define the relationship to the Genre model
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
