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
        Schema::create('order_container_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('container_id');

            $table->decimal('max_capacity', 15, 2)->comment('Maximum weight in KG or Tons');
            $table->tinyInteger('capacity_unit')->default(1)->comment('1=KG, 2=Tons');
            $table->decimal('base_price', 15, 2)->comment('Base price per container type');

            $table->BigInteger('my_order_qty')->default(0);
            $table->decimal('my_capacity', 15, 2)->default(0.00);
            $table->decimal('sub_price', 15, 2)->default(0.00);
            $table->unsignedBigInteger('add_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');
            $table->foreign('add_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_containers');
    }
};
