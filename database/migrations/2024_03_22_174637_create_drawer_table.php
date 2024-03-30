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
        Schema::create('drawer', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->float('opening_balance');
            $table->float('cash_float');
            $table->float('today_sales');
            $table->float('expected_amount');
            $table->float('counted_amount');
            $table->string('remark')->nullable()->default('None');
            $table->float('cash_balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drawer');
    }
};
