<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_harians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->comment('Tanggal menu berlaku');
            $table->string('nama_item')->comment('Nama bahan makanan, contoh: Nasi Putih');
            $table->string('takaran', 30)->comment('Takaran saji, contoh: 200 g');
            $table->decimal('energi', 7, 2)->default(0)->comment('Energi dalam kkal');
            $table->decimal('protein', 6, 2)->default(0)->comment('Protein dalam gram');
            $table->decimal('lemak', 6, 2)->default(0)->comment('Lemak dalam gram');
            $table->decimal('karbo', 6, 2)->default(0)->comment('Karbohidrat dalam gram');
            $table->decimal('serat', 6, 2)->default(0)->comment('Serat dalam gram');
            $table->unsignedTinyInteger('urutan')->default(1)->comment('Urutan tampil item dalam satu hari');
            $table->timestamps();

            // Index agar query per tanggal cepat
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_harians');
    }
};
