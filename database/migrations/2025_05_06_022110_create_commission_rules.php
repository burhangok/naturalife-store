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
        Schema::create('commission_rules', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->comment('Derinlik seviyesi');
            $table->decimal('percentage', 5, 2)->comment('Komisyon oranı (%)');
            $table->boolean('is_active')->default(true)->comment('Kurallar aktif mi?');
            $table->timestamps();

            $table->integer('created_admin_id')->unsigned()->nullable();
            $table->integer('updated_admin_id')->unsigned()->nullable();

            $table->foreign('created_admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_admin_id')->references('id')->on('admins')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_rules');
    }
};
