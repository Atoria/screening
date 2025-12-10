<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->date('date_of_birth');
            $table->enum('headache_frequency', [
                \App\Enums\HeadacheFrequencyEnum::DAILY->value,
                \App\Enums\HeadacheFrequencyEnum::WEEKLY->value,
                \App\Enums\HeadacheFrequencyEnum::MONTHLY->value,
            ]);
            $table->string('daily_frequency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screenings');
    }
};
