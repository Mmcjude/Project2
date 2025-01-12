<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade'); // Foreign key to authors table
            $table->string('name', 256); // Name of the book
            $table->text('description')->nullable(); // Description of the book
            $table->decimal('price', 8, 2)->nullable(); // Price of the book
            $table->integer('year'); // Year of publication
            $table->string('image', 256)->nullable(); // Image path of the book
            $table->boolean('display'); // Whether the book is displayed
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
