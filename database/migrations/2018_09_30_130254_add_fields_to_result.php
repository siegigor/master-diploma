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
            $table->string('rated')->nullable();
            $table->text('genre')->nullable();
            $table->string('runtime')->nullable();
            $table->string('director')->nullable();
            $table->text('writer')->nullable();
            $table->text('actors')->nullable();
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('awards')->nullable();
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
