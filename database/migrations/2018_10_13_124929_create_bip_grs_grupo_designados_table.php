<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBipGrsGrupoDesignadosTable.
 */
class CreateBipGrsGrupoDesignadosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bip_grs_grupo_designados', function(Blueprint $table) {
            $table->increments('grs_grupo_designado_id');
            $table->string('grs_descricao',100)->unique();
            $table->integer('grs_emp_empresa_id');

            $table->foreign('grs_emp_empresa_id')
                ->references('emp_empresa_id')
                ->on('BipEmpEmpresas')
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
        Schema::create('bip_grs_grupo_designados', function(Blueprint $table){
            $table->dropForeign('bip_grs_grupo_designados_grs_emp_empresa_id_foreign');
        });

        Schema::create('bip_inc_incidentes', function(Blueprint $table){
            $table->dropForeign('bip_inc_incidentes_inc_grs_grupo_designado_id_foreign');
        });

		Schema::drop('bip_grs_grupo_designados');
	}
}
