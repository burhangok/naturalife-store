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
        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id')->comment('Komisyon alan affiliate id');
            $table->string('order_id')->nullable()->comment('İlgili sipariş id');
            $table->unsignedBigInteger('from_affiliate_id')->nullable()->comment('Hangi alt üyeden geldi');
            $table->integer('level')->default(1)->nullable()->comment('Kaçıncı seviyeden komisyon');
            $table->decimal('amount', 12, 4)->nullable()->comment('Komisyon tutarı');
            $table->decimal('percentage', 5, 2)->nullable()->comment('Komisyon oranı (%)');
            $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])->default('pending')->comment('Komisyon durumu');
            $table->text('description')->nullable()->comment('Açıklama');
            $table->timestamp('paid_at')->nullable()->comment('Ödeme tarihi');
            $table->timestamps();

            $table->foreign('affiliate_id')
                ->references('id')->on('affiliates')
                ->onDelete('cascade');
            $table->foreign('order_id')
                ->references('increment_id')->on('orders')
                ->onDelete('set null');
            $table->foreign('from_affiliate_id')
                ->references('id')->on('affiliates')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_commissions');
    }
};
