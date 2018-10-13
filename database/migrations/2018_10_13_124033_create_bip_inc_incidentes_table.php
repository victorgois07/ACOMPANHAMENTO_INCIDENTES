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
            $table->integer('inc_sum_sumario_id');
            $table->integer('inc_grs_grupo_designado_id');
            $table->integer('inc_pri_prioridade_id');
            $table->integer('inc_coi_codigo_ic_id');

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
            $table->dropForeign([
                'bip_inc_incidentes_inc_sum_sumario_id_foreign',
                'bip_inc_incidentes_inc_grs_grupo_designado_id_foreign',
                'bip_inc_incidentes_inc_pri_prioridade_id_foreign',
                'bip_inc_incidentes_inc_coi_codigo_ic_id_foreign'
            ]);
        });

        Schema::create('bip_inh_incidente_historicos', function(Blueprint $table){
            $table->dropForeign('bip_inh_incidente_historicos_inh_inc_incidente_id_foreign');
        });
	    
		Schema::drop('bip_inc_incidentes');
	}
}
