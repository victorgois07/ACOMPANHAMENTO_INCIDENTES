<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBipIncIncidentesTable.
 */
class CreateBipIncIncidentesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bip_inc_incidentes', function(Blueprint $table) {
            $table->increments('inc_incidente_id');

            $table->string('inc_codigo_incidente',15)->unique();

            $table->foreign('inc_sum_sumario_id')
                ->references('sum_sumario_id')
                ->on('BipSumSumarios')
                ->onDelete('cascade');

            $table->foreign('inc_grs_grupo_designado_id')
                ->references('grs_emp_empresa_id')
                ->on('BipGrsGrupoDesignados')
                ->onDelete('cascade');

            $table->foreign('inc_pri_prioridade_id')
                ->references('pri_prioridade_id')
                ->on('BipPriPrioridades')
                ->onDelete('cascade');

            $table->foreign('inc_coi_codigo_ic_id')
                ->references('coi_codigo_ic_id')
                ->on('BipCoiCodigoIcs')
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

        Schema::create('bip_inc_incidentes', function(Blueprint $table){
            $table->dropForeign(['inc_sum_sumario_id','inc_grs_grupo_designado_id','inc_pri_prioridade_id','inc_coi_codigo_ic_id']);
        });
	    
		Schema::drop('bip_inc_incidentes');
	}
}
