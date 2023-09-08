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
        Schema::create('boats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boat_model_id')->index();
            $table->string('title');
            $table->integer('price');
            $table->string('condition', 30)->index();
            $table->text('description');
            $table->unsignedInteger('year');
            $table->decimal('length');
            $table->decimal('beam');
            $table->string('fuel_type', 30)->index();
            $table->unsignedInteger('fuel_capacity');
            $table->unsignedInteger('horsepower');
            $table->unsignedTinyInteger('number_of_engines');
            $table->unsignedInteger('persons');
            $table->timestamps();

            $table->foreign('boat_model_id')->references('id')->on('boat_models')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boats');
    }
};
