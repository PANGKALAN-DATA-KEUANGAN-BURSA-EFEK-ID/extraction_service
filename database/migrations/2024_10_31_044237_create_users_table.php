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
        Schema::create('Users', function (Blueprint $table) {
            $table->id('UserID');
            $table->foreignId('RoleUserID')
                  ->references('RoleUserID')
                  ->on('RoleUsers');
            $table->string('RoleUserName', 255);
            $table->double('SubscriptionPriceIdr', 10, 2);
            $table->double('SubscriptionPercentage', 8, 2);
            $table->string('FullName', 255);
            $table->string('Email', 255);
            $table->string('Password', 20);
            $table->string('Token', 255);
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
        Schema::dropIfExists('Users');
    }
};
