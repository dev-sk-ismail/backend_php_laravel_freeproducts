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
        Schema::table('users', function (Blueprint $table) {
            $table->string('amazon_order_id')->nullable();
            $table->string('product_name')->nullable();
            $table->text('product_review')->nullable();
            $table->string('product_feedback')->nullable();
            $table->string('product_rating')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'amazon_order_id',
                'product_name',
                'product_review',
                'product_feedback',
                'product_rating',
                'address',
                'phone',
                'city',
                'state',
                'country',
                'zip_code'
            ]);
        });
    }
};
