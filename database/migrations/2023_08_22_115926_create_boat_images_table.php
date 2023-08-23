<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boat_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boat_id')->index();
            $table->string('url');
            $table->timestamps();

            $table->foreign('boat_id')->references('id')->on('boats')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boat_images');
    }
};
