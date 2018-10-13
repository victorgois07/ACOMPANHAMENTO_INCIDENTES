<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBipCoiCodigoIcsTable.
 */
class CreateBipCoiCodigoIcsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bip_coi_codigo_ics', function(Blueprint $table) {
            $table->increments('coi_codigo_ic_id');
            $table->string('coi_descricao',100)->unique();
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
            $table->dropForeign('bip_inc_incidentes_inc_coi_codigo_ic_id_foreign');
        });
		Schema::drop('bip_coi_codigo_ics');
	}
}
