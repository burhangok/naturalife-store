<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cart_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('affiliate_id')->nullable()->after('id');
            $table->decimal('commission_percentage', 5, 2)->nullable()->comment('Komisyon oranı (%)');
            $table->index('affiliate_id');
        });
    }

    public function down()
    {
        Schema::table('cart_rules', function (Blueprint $table) {
            $table->dropIndex(['affiliate_id']);
            $table->dropColumn('affiliate_id');
        });
    }
};
