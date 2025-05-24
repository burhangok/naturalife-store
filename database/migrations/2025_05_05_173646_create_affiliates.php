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
        Schema::create('affiliates', function (Blueprint $table) {
            // id() bigIncrements() ile aynı unsigned BIGINT
            $table->id();
            // parent_id, affiliates.id'ye nullable foreign key
            $table->unsignedBigInteger('parent_id')
                ->nullable()
                ->comment('Üst affiliate id');
            $table->integer('customer_id')->unsigned()->nullable();

            $table->string('affiliate_code', 16)
                ->unique()
                ->comment('Benzersiz affiliate kodu');

            $table->integer('level')
                ->default(0)
                ->comment('Ağacı hiyerarşik seviye');

            $table->enum('status', ['active', 'inactive', 'suspended'])
                ->default('active')
                ->comment('Affiliate durumu');

            $table->decimal('total_commission_earned', 12, 2)
                ->default(0.00)
                ->comment('Bugüne kadar biriken komisyon');

            $table->timestamp('last_commission_at')
                ->nullable()
                ->comment('En son komisyon kazanma tarihi');

            $table->timestamp('joined_at')
                ->useCurrent()
                ->comment('Programa katılma tarihi');

            $table->text('description')
                ->nullable()
                ->comment('Affiliate açıklama notu');




            $table->index('parent_id');



            $table->foreign('parent_id')
                ->references('id')
                ->on('affiliates')
                ->onDelete('set null');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->timestamps();


        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliates');
    }
};
