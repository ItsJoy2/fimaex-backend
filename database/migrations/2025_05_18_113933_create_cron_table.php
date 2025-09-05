<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cron', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('last_cron');
            $table->timestamps();
        });

        DB::table('cron')->insert([
            'name' => 'everyTime',
            'last_cron' => Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cron');
    }
};
