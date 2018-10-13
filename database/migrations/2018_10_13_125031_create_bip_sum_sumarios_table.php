<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBipSumSumariosTable.
 */
class CreateBipSumSumariosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bip_sum_sumarios', function(Blueprint $table) {
            $table->increments('sum_sumario_id');
            $table->string('sum_descricao',500)->unique();
            $table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::create('bip_inc_incidentes', function(Blueprint $table){
            $table->dropForeign('bip_inc_incidentes_inc_sum_sumario_id_foreign');
        });
		Schema::drop('bip_sum_sumarios');
	}
}
