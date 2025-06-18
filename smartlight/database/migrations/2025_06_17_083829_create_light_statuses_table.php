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
        Schema::create('light_statuses', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_on')->default(false);
            $table->integer('ldr_value');
            $table->string('mode')->default('auto'); // auto or manual
            $table->boolean('manual_override')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('light_statuses');
    }
};
