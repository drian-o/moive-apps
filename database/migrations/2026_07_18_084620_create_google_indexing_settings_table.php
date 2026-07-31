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
        Schema::create('google_indexing_settings', function (Blueprint $table) {

            $table->id();

            $table->json('credential')->nullable();

            $table->boolean('is_connected')->default(false);

            $table->timestamp('last_test_at')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_indexing_settings');
    }
};
