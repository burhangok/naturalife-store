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
        Schema::create('affiliate_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->onDelete('cascade');

            // Ödeme Bilgileri
            $table->decimal('amount', 15, 2)->nullable(); // Ödeme tutarı
            $table->string('currency', 3)->default('EUR')->nullable();// Para birimi
            $table->enum('payment_method', ['sepa', 'bank', 'paypal', 'wise', 'revolut', 'stripe'])->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('description')->nullable(); // Ödeme açıklaması
            $table->text('payment_file_path')->nullable(); // Admin notları


            $table->integer('created_admin_id')->unsigned()->nullable();
            $table->integer('updated_admin_id')->unsigned()->nullable();

            $table->foreign('created_admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_admin_id')->references('id')->on('admins')->onDelete('set null');




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_payments');
    }


};
