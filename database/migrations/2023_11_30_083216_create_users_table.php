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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string("address");
            $table->string('email')->unique();
            $table->string('api_token')->nullable();
            $table->string('status')->default('online');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string("registration_code")->nullable();
            $table->foreignId("profile_id")->constrained("profile")->cascadeOnDelete()->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
