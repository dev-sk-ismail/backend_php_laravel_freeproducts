<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductAndOrderInfoToLeads extends Migration
{
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('product_id')->nullable();
            $table->string('variant_id')->nullable();
            $table->boolean('is_voucher')->default(false);
            $table->text('shopify_response')->nullable();
            $table->enum('order_status', ['voucher', 'draft', 'fulfilled'])->default('draft');
        });
    }

    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->dropColumn('variant_id');
            $table->dropColumn('is_voucher');
            $table->dropColumn('shopify_response');
            $table->dropColumn('order_status');
        });
    }
}
