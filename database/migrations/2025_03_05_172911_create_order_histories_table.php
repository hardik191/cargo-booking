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
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('description')->nullable();
            $table->tinyInteger('order_status')->default('1')->comment('1 for Pending, 2 for Accepted, 3 for Rejected, 4 for Shipped, 5 for Deliver, 6 for Payment Pending, 7 for Payment Successful, 8 for Payment Cancelled');
            $table->unsignedBigInteger('add_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('add_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_histories');
    }
};
