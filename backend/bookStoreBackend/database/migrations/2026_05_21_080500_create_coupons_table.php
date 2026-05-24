<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('discount_type'); // 'percent' or 'fixed'
            $table->decimal('discount_value', 10, 2);
            $table->date('expiry_date')->nullable();
            $table->integer('max_uses')->nullable(); // null represents unlimited (infinity)
            $table->integer('uses_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
