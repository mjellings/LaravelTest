<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('cash')->unsigned()->default('0');
            $table->integer('turns_stored_max')->unsigned()->default(50);
            $table->integer('turns')->unsigned()->default(30);
            $table->integer('turns_roll_max')->unsigned()->default(3);
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
            $table->dropColumn('cash');
            $table->dropColumn('turns_roll_max');
            $table->dropColumn('turns');
            $table->dropColumn('turns_stored_max');
        });
    }
}
