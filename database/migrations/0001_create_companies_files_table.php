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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("unique_name")->unique();
            $table->string("path");
            $table->string("extension");
            $table->float("size");
            $table->dateTime("created_at")->default(date("Y-m-d H:i:s"));
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files')->onDelete("cascade");
            $table->dateTime("created_at")->default(date("Y-m-d H:i:s"));
        });
        Schema::table('files', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('size');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
