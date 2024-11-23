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
        Schema::create('master_sources', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->text('alias')->nullable();
            $table->timestamps();
        });

        Schema::create('master_dispositions', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->unsignedBigInteger('employee_id');
            $table->text('alias')->nullable();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::create('master_employee_types', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->text('alias')->nullable();
            $table->timestamps();
        });


        Schema::create('master_employee_ranks', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->text('alias')->nullable();
            $table->timestamps();
        });

        Schema::create('master_employee_educations', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->text('alias')->nullable();
            $table->timestamps();
        });

        Schema::create('master_employee_colleges', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->text('alias')->nullable();
            $table->timestamps();
        });

        Schema::create('master_employee_work_units', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->text('alias')->nullable();
            $table->timestamps();
        });

        Schema::create('master_addresses', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->unsignedBigInteger('employee_id');
            $table->text('alias')->nullable();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_sources');
        Schema::dropIfExists('master_dispositions');
        Schema::dropIfExists('master_employee_types');
        Schema::dropIfExists('master_employee_ranks');
        Schema::dropIfExists('master_employee_educations');
        Schema::dropIfExists('master_employee_colleges');
        Schema::dropIfExists('master_employee_work_units');
        Schema::dropIfExists('master_addresses');
    }
};
