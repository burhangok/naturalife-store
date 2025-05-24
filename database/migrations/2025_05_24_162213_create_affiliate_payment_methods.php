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
        Schema::create('affiliate_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id')->comment('Affiliate id');

            // Temel Ödeme Tercihleri
            $table->enum('payment_method', ['sepa', 'bank', 'paypal', 'wise', 'revolut', 'stripe'])->nullable();
            $table->enum('tax_status', ['individual', 'company', 'freelancer', 'vat_registered'])->nullable();

            // Banka / SEPA Bilgileri
            $table->string('account_holder_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic_swift_code')->nullable();
            $table->text('bank_address')->nullable();

            // PayPal Bilgileri
            $table->string('paypal_email')->nullable();
            $table->string('paypal_merchant_id')->nullable();

            // Dijital Cüzdan Bilgileri (Wise/Revolut)
            $table->string('digital_wallet_email')->nullable();
            $table->string('digital_wallet_account_id')->nullable();

            // Vergi ve Kimlik Bilgileri
            $table->string('tax_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('tax_country', 2)->nullable(); // DE, FR, NL
            $table->string('company_name')->nullable();
            $table->string('company_registration_number')->nullable();

            // Fatura Adresi
            $table->string('billing_name')->nullable();
            $table->string('billing_street')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_country', 2)->nullable();

            // Ödeme Koşulları ve Notlar
            $table->integer('payment_delay_days')->default(15); // 0, 7, 15, 30
            $table->string('currency', 3)->default('EUR'); // EUR, USD
            $table->text('special_notes')->nullable();

            
            $table->foreign('affiliate_id')
            ->references('id')->on('affiliates')
            ->onDelete('cascade');

            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_payment_methods');
    }
};
