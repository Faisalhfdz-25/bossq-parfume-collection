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
        Schema::create('detail_list_belanja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade');
            $table->integer('qty');
            $table->integer('harga');
            $table->string('tempat');
            $table->integer('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_list_belanja');
    }
};
