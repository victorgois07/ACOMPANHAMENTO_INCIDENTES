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
            $table->integer('inh_inc_incidente_id');
            $table->integer('inh_his_historico_id');

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
            $table->dropForeign(['bip_inh_incidente_historicos_inh_inc_incidente_id_foreign','bip_inh_incidente_historicos_inh_his_historico_id_foreign']);
        });
		Schema::drop('bip_inh_incidente_historicos');
	}
}
