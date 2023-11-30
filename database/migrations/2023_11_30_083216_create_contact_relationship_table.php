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
        Schema::create('contact_relationship', function (Blueprint $table) {
            $table->foreignId('user_id_1')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id_2')->constrained('users')->onDelete('cascade');
            $table->primary(['user_id_1', 'user_id_2']);
            $table->string("message_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_relationship');
    }
};
