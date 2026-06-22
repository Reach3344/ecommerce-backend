<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $theme) {
            $theme->id();
            $theme->string('name');
            $theme->string('email')->unique();
            $theme->string('password');
            $theme->boolean('is_admin')->default(false); // To separate Admins from normal users [cite: 12]
            $theme->rememberToken();
            $theme->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};