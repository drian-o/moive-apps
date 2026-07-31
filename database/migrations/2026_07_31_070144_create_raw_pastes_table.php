<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_pastes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('slug', 32)->unique();

            $table->string('filename', 150)
                ->default('file.txt');

            $table->string('language', 30)
                ->default('text');

            $table->string('visibility', 20)
                ->default('unlisted')
                ->index();

            $table->longText('content');

            $table->unsignedBigInteger('views')
                ->default(0);

            $table->timestamp('expires_at')
                ->nullable()
                ->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_pastes');
    }
};