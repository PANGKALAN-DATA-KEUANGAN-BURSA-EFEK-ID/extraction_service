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
        Schema::create('UserReplies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('UserID')
                  ->references('UserID')
                  ->on('Users');
            $table->foreignId('UserPostID')
                ->references('UserPostID')
                ->on('UserPosts');
            $table->text('ReplyText');
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
        Schema::dropIfExists('UserReplies');
    }
};
