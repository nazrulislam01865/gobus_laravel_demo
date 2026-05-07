<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('promotions')) {
            Schema::create('promotions', function (Blueprint $table) {
                $table->id();
                $table->string('promo_code', 20)->unique();
                $table->enum('discount_type', ['Percentage', 'Fixed Amount']);
                $table->decimal('discount_value', 10, 2);
                $table->string('route');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
