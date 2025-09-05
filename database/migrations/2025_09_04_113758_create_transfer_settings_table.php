<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_transfer', 12, 2)->default(0);
            $table->decimal('max_transfer', 12, 2)->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        DB::table('transfer_settings')->insert([
            'min_transfer' => 100,
            'max_transfer' => 5000,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_settings');
    }
};
