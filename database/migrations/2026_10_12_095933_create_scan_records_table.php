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
        Schema::create('scan_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfid_cards_id')->references('id')->on('rfid_cards')->cascadeOnDelete();
            $table->foreignId('device_id')->references('id')->on('devices')->cascadeOnDelete()->nullable();
            $table->dateTime('scanned_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_records');
    }
};
