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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('order_amount', 15, 2)->default(0);
            $table->string('payment_document')->nullable();
            $table->integer('payment_mode')->default(0)->comment('0 for Pending, 1 for Cash, 2 for Cheque, 3 for Gpay, 4 for PhonePe, 5 for Paytm, 6 for Others');
            $table->tinyInteger('payment_status')->default(1)->comment('1 For Pending ,2 For Successful, 3 For Cancelled');
            $table->dateTime('payment_date')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
