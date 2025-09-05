<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdraw_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('min_withdraw');
            $table->integer('max_withdraw');
            $table->integer('charge');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        DB::table('withdraw_settings')->insert([
           'min_withdraw' => '10',
           'max_withdraw' => '10000',
           'charge' => '5',
           'status' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_settings');
    }
};
