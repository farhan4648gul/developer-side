<?php

class Admin_Create_Server_Cpu {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_cpu', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('cpu_id');
		    $table->integer('server_id');
		    $table->string('cpu_user', 100);
		    $table->string('cpu_nice', 100);
		    $table->string('cpu_system', 100);
		    $table->string('cpu_iowait', 100);
		    $table->string('cpu_idle', 100);
		    $table->string('cpu_steal', 100);
		    $table->date('cpu_date');
		    $table->timestamps();

		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('server_cpu');
	}

}