use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            // Define foreign key to the authors table
            $table->foreignId('author_id')->constrained()->onDelete('cascade');  
            // Define foreign key to the genres table
            $table->foreignId('genre_id')->constrained()->onDelete('set null');  
            $table->string('name', 256);
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('year');
            $table->string('image', 256)->nullable();
            $table->boolean('display')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
}
