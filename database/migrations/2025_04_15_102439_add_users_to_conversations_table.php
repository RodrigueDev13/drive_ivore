<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('user_one_id')->after('id');
            $table->unsignedBigInteger('user_two_id')->after('user_one_id');
            $table->timestamp('last_message_at')->nullable()->after('user_two_id');
        });
    }

    public function down()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn(['user_one_id', 'user_two_id', 'last_message_at']);
        });
    }

};
