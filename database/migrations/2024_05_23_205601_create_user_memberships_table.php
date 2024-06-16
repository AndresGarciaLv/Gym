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
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_gym')->constrained('gyms')->onDelete('cascade');
            $table->foreignId('id_membership')->constrained('memberships')->onDelete('cascade');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->integer('duration_days')->nullable();
            $table->boolean('isActive')->default(true);
            $table->boolean('is_renewal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_memberships');
    }
};
