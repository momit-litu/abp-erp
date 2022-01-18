<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDraftColumnWithBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->enum('draft', ['Yes','No'])->default('No')->after('status');
            $table->enum('show_seat_limit', ['Yes','No'])->default('No')->after('draft');
            $table->foreignId('created_by')->after('featured');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn('draft');
            $table->dropColumn('show_seat_limit');
            $table->dropColumn('created_by');
        });
    }
}
