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
            $table->string('desc')->after('email');
            $table->string('website')->after('email');
            $table->string('location')->after('email');
            $table->string('timezone')->after('email');
            $table->string('occupation')->after('email');
            $table->string('signature')->after('email');
            $table->string('facebook')->after('email');
            $table->string('instagram')->after('email');
            $table->string('x')->after('email');
            $table->string('youtube')->after('email');
            $table->string('github')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['desc', 'website', 'location', 'timezone', 'occupation', 'signature', 'facebook', 'instagram', 'x', 'youtube', 'github']);
        });
    }
};
