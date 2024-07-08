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
        Schema::create('aduan_forward_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aduan_id')->constrained('aduans')->onDelete('cascade');
            $table->string('from_program_studi');
            $table->string('to_program_studi');
            $table->unsignedBigInteger('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->foreign('aduan_id')->references('id')->on('aduans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduan_forward_histories');
    }
};
