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
        Schema::create('order_charges', function (Blueprint $table) {
            $table->id();
            $table->string('charge_name');
            $table->tinyInteger('charge_type')->default(0)->comment('default(0), 0= No, 1=Addition (+), 2=Subtraction (-), 3=Multiplication (*), 4=Division (/), 5=Modulus (%)');
            $table->decimal('charge_value', 15, 2)->default(0)->comment('Value used in calculations');
            $table->tinyInteger('status')->default(1)->comment('1=Active, 2=Inactive, 3=Deleted');
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
        Schema::dropIfExists('order_charges');
    }
};
