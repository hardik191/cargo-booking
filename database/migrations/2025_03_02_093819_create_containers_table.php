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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('container_type')->comment('20ft, 40ft, 45ft, etc.');
            $table->integer('max_container')->default(1)->comment('Maximum number of containers allowed'); //new column
            $table->integer('max_capacity')->comment('Maximum weight in KG or Tons');
            $table->tinyInteger('capacity_unit')->default(1)->comment('1=KG, 2=Tons');
            $table->decimal('base_price', 15, 2)->comment('Base price per container type');
            $table->tinyInteger('status')->default(1)->comment('1=Active, 2=Inactive');
            $table->unsignedBigInteger('add_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('add_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
