<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBipInhIncidenteHistoricosTable.
 */
class CreateBipInhIncidenteHistoricosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bip_inh_incidente_historicos', function(Blueprint $table) {
            $table->increments('inh_incidente_historico_id');

            $table->dateTime('inh_criado');
            $table->dateTime('inh_resolvido');

            $table->foreign('inh_inc_incidente_id')
                ->references('inc_incidente_id')
                ->on('BipIncIncidentes')
                ->onDelete('cascade');

            $table->foreign('inh_his_historico_id')
                ->references('his_historico_id')
                ->on('BipHisHistoricos')
                ->onDelete('cascade');

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
            $table->dropForeign(['inh_inc_incidente_id','inh_his_historico_id']);
        });
		Schema::drop('bip_inh_incidente_historicos');
	}
}
