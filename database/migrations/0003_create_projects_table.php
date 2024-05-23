<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\ProjectStateEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
			$enumValues = UtilsHelper::getCasesFromEnum(ProjectStateEnum::cases());
            $table->id();
            $table->string('name');
            $table->string('url_prod')->nullable();
            $table->string('url_preprod')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('hours', 10);
            $table->decimal('rate', 10, 2);
            $table->enum('state', $enumValues)->default(\App\ProjectStateEnum::NOT_VALIDATED->value);
            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->dateTime("start_date");
            $table->dateTime("end_date");
            $table->dateTime("created_at")->default(date("Y-m-d H:i:s"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
