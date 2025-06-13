<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductDetailsToLeadsTable extends Migration
{
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('product_id')->nullable()->after('product_name');
            $table->string('variant_id')->nullable()->after('product_id');
            $table->boolean('is_voucher')->default(false)->after('variant_id');
            $table->string('voucher_code')->nullable()->after('is_voucher');
            $table->enum('order_status', ['draft', 'voucher', 'fulfilled'])->default('draft')->after('status');
            $table->string('fulfillment_hash')->nullable()->after('order_status');
        });
    }

    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'product_id',
                'variant_id',
                'is_voucher',
                'voucher_code',
                'order_status',
                'fulfillment_hash'
            ]);
        });
    }
}
