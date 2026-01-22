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
        Schema::table('users', function (Blueprint $table) {
            $table->string("surname");
            $table->string("CF");
            $table->string("tel", 15);
            $table->boolean("admin")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("surname");
            $table->removeColumn("CF");
            $table->removeColumn("tel");
            $table->removeColumn("admin");
        });
    }
};
