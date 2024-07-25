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
        Schema::create('enterprises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('fantasy_name', 250);
            $table->string('corporate_reason', 250);
            $table->string('state_registration', 250);
            $table->string('cnpj', 20)->unique();
            $table->string('municipal_registration',250);
            $table->string('responsible', 100);
            $table->string('foundation',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprises');
    }
};
