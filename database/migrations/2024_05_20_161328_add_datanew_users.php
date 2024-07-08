<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**D:\api_usmhub\database\migrations\2024_05_20_161328_add_datanew_users.php
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('img_profile')->nullable()->after('email');
            $table->date('tgl_lahir')->nullable();
            $table->enum('progdi', ['Teknik Informatika', 'Sistem Informasi', 'Ilmu Komunikasi', 'Pariwisata']);
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('img_profile');
            $table->dropColumn('tgl_lahir');
            $table->dropColumn('progdi');
            $table->dropColumn('gender');
        });
    }
};
