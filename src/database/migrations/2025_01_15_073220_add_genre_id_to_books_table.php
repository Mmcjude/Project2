// database/migrations/xxxx_xx_xx_xxxxxx_add_genre_id_to_books_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenreIdToBooksTable extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedBigInteger('genre_id')->nullable()->after('author_id'); // Add genre_id column
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['genre_id']);
            $table->dropColumn('genre_id');
        });
    }
}
