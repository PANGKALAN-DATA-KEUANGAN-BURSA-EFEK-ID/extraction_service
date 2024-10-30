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
        Schema::create('FinancialRatios', function (Blueprint $table) {
            $table->id('FinancialRatioID');
            $table->foreignId('CompanyID')
                ->references('CompanyID')
                ->on('Companies');
            $table->string('CompanyName', 255);
            $table->string('CompanyCode', 10);
            $table->string('FinancialRatioName', 255);
            $table->json('FinancialRatioValue')->nullable();
            $table->char('Status', 1);
            $table->timestamp('CreateDate')->nullable();
            $table->string('CreateWho', 255);
            $table->timestamp('ChangeDate')->nullable();
            $table->string('ChangeWho', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FinancialRatios');
    }
};
