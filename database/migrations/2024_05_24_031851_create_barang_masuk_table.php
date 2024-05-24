<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->constrained('products'); 
            $table->foreignId('suppliers_id')->constrained('suppliers');
            $table->integer('qty');
            $table->dateTime('tanggal');
            $table->integer('harga_per_unit')->nullable();
            $table->integer('total_harga')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            
        });

        
        DB::unprepared('
            CREATE TRIGGER update_stok_after_insert
            AFTER INSERT ON barang_masuk
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET stock = stock + NEW.qty
                WHERE id = NEW.products_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
