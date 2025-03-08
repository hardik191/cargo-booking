<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('sender_name');
            $table->string('sender_email');
            $table->integer('sender_country_code')->nullable();
            $table->string('sender_phone_no', 20);
            $table->unsignedBigInteger('sender_port_id');
            $table->string('receiver_name');
            $table->string('receiver_email');
            $table->integer('receiver_country_code')->nullable();
            $table->string('receiver_phone_no', 20);
            $table->unsignedBigInteger('receiver_port_id');
            $table->decimal('total_capacity', 15, 2)->default(0);
            $table->integer('total_qty')->default(0);
            $table->decimal('total_price', 15, 2)->default(0.00);
            $table->decimal('total_charge', 15, 2)->default(0.00);
            $table->decimal('final_total', 15, 2)->default(0.00);
            $table->tinyInteger('order_status')->default(1)->comment('1 For Pending ,2 For Accepted, 3 For Rejected, 4 For Shipped, 5 For Deliver');
            $table->tinyInteger('payment_status')->comment('1 For Pending ,2 For Successful, 3 For Cancelled');
            $table->tinyInteger('is_deleted')->default(1)->comment('1 For No ,2 For Yes');
            $table->unsignedBigInteger('add_by')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('sender_port_id')->references('id')->on('ports');
            $table->foreign('receiver_port_id')->references('id')->on('ports');
            $table->foreign('add_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
