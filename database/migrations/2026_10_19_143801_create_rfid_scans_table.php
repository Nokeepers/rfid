<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rfid_scans', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 50);
            $table->foreignId('rfid_card_id')->nullable()->constrained()->nullOnDelete();
            $table->string('device_id', 50)->default('arduino-uno-01');
            $table->enum('status', ['authorized', 'unknown', 'inactive'])->default('unknown');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['uid', 'created_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfid_scans');
    }
};
