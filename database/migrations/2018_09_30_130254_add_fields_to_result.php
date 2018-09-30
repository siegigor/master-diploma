<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddFieldsToResult
 */
class AddFieldsToResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('result', function (Blueprint $table) {
            $table->string('rated');
            $table->text('genre');
            $table->string('runtime');
            $table->string('director');
            $table->text('writer');
            $table->text('actors');
            $table->string('language');
            $table->string('country');
            $table->string('awards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('result', function (Blueprint $table) {
            $table->dropColumn('rated');
            $table->dropColumn('runtime');
            $table->dropColumn('director');
            $table->dropColumn('writer');
            $table->dropColumn('actors');
            $table->dropColumn('language');
            $table->dropColumn('country');
            $table->dropColumn('awards');
        });
    }
}
