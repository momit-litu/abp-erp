<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDropoutColumnWithBatchStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('batch_students', function (Blueprint $table) {
            $table->enum('dropout', ['Yes','No'])->default('No')->after('status');
            $table->enum('welcome_email', ['Sent','Not-sent'])->default('Not-sent')->after('dropout');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('batch_students', function (Blueprint $table) {
            $table->dropColumn('dropout');
        });
    }
}
