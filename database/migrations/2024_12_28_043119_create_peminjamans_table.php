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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id(); // Primary Key dengan tipe BIGINT UNSIGNED
            $table->unsignedBigInteger('book_id'); // Foreign Key untuk buku
            $table->string('borrower_name'); // Nama peminjam
            $table->date('borrow_date'); // Tanggal pinjam
            $table->date('return_date')->nullable(); // Tanggal pengembalian (boleh null)
            $table->timestamps(); // Kolom created_at dan updated_at

            // Definisi Foreign Key
            $table->foreign('book_id') // Kolom yang menjadi foreign key
                ->references('id') // Merujuk ke kolom id di tabel books
                ->on('books') // Nama tabel referensi
                ->onDelete('cascade'); // Hapus peminjaman jika buku dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
