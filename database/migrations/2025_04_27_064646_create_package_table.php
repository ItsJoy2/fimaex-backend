<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('package', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('amount');
            $table->string('icon')->nullable();
             $table->decimal('refer_bonus');
            $table->boolean('active');
            $table->timestamps();
        });

        DB::table('package')->insert([
            'name' => 'Become a Founder',
            'amount' => '120',
            'refer_bonus' => 20,
            'active' => '1'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package');
    }
};
