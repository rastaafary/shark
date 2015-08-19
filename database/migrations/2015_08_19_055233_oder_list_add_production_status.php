<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OderListAddProductionStatus extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_list', function($table)
        {
            $table->integer('production_status')->nullable()->unsigned()->index();
            $table->foreign('production_status')->references('id')->on('production_sequences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_list', function($table)
        {
            $table->dropColumn('production_status');
        });
    }

}
