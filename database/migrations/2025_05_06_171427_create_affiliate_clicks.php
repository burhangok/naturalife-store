<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('affiliate_clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id')->comment('Affiliate id');

            // Temel veriler (mevcut)
            $table->string('ip_address', 45)->nullable()->comment('IP adresi');
            $table->string('user_agent')->nullable()->comment('User agent');
            $table->string('referrer_url')->nullable()->comment('Yönlendiren URL');

            // Geliş kanalı ve cihaz bilgileri
            $table->string('device_type')->nullable()->comment('Cihaz tipi: desktop, mobile, tablet');
            $table->string('browser')->nullable()->comment('Tarayıcı adı');
            $table->string('browser_version')->nullable()->comment('Tarayıcı versiyonu');
            $table->string('operating_system')->nullable()->comment('İşletim sistemi');
            $table->string('operating_system_version')->nullable()->comment('İşletim sistemi versiyonu');
            $table->boolean('is_bot')->default(false)->comment('Bot mu?');

            // Konum bilgileri
            $table->string('country')->nullable()->comment('Ülke');
            $table->string('region')->nullable()->comment('Bölge/Eyalet');
            $table->string('city')->nullable()->comment('Şehir');

            // UTM parametreleri
            $table->string('utm_source')->nullable()->comment('UTM kaynak');
            $table->string('utm_medium')->nullable()->comment('UTM ortam');
            $table->string('utm_campaign')->nullable()->comment('UTM kampanya');
            $table->string('utm_term')->nullable()->comment('UTM arama terimi');
            $table->string('utm_content')->nullable()->comment('UTM içerik');

            // İstatistik bilgileri
            $table->boolean('converted')->default(false)->comment('Dönüşüm oldu mu?');
            $table->unsignedBigInteger('conversion_id')->nullable()->comment('Dönüşüm kimliği (sipariş, kayıt vb.)');
            $table->string('landing_page')->nullable()->comment('İlk giriş yapılan sayfa');
            $table->timestamp('first_visit_time')->nullable()->comment('İlk ziyaret zamanı');
            $table->timestamp('last_visit_time')->nullable()->comment('Son ziyaret zamanı');
            $table->integer('visit_count')->default(1)->comment('Ziyaret sayısı');

            // Oturum bilgileri
            $table->string('session_id')->nullable()->comment('Oturum kimliği');
            $table->integer('time_on_site')->nullable()->comment('Sitede geçirilen süre (saniye)');

            // Müşteri bilgileri (eğer biliniyorsa)
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('order_id')->unsigned()->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('affiliate_id')
                ->references('id')->on('affiliates')
                ->onDelete('cascade');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_clicks');
    }
};
