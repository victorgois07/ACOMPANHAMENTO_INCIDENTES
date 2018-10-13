<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBipPriPrioridadesTable.
 */
class CreateBipPriPrioridadesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bip_pri_prioridades', function(Blueprint $table) {
            $table->increments('pri_prioridade_id');
            $table->string('pri_descricao',25)->unique();
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
            $table->dropForeign('bip_inc_incidentes_inc_pri_prioridade_id_foreign');
        });
		Schema::drop('bip_pri_prioridades');
	}
}
