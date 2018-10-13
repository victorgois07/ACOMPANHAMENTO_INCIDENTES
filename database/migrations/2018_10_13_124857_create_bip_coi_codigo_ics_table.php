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
		Schema::drop('bip_coi_codigo_ics');
	}
}
