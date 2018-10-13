<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBipEmpEmpresasTable.
 */
class CreateBipEmpEmpresasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bip_emp_empresas', function(Blueprint $table) {
            $table->increments('emp_empresa_id');
            $table->string('emp_empresa_id',100)->unique();
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
		Schema::drop('bip_emp_empresas');
	}
}
