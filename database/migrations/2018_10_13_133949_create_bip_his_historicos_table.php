<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBipHisHistoricosTable.
 */
class CreateBipHisHistoricosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bip_his_historicos', function(Blueprint $table) {
            $table->increments('his_historico_id');
            $table->text('his_decricao_problema');
            $table->text('his_decricao_resolucao');
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
        Schema::create('bip_inh_incidente_historicos', function(Blueprint $table){
            $table->dropForeign('bip_inh_incidente_historicos_inh_his_historico_id_foreign');
        });
		Schema::drop('bip_his_historicos');
	}
}
