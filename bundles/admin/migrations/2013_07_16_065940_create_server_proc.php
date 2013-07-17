<?php

class Admin_Create_Server_Proc {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_proc', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('proc_id');
		    $table->integer('server_id');
		    $table->string('proc_mem', 100);
		    $table->string('proc_cpu', 100);
		    $table->string('proc_arg', 100);
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
		Schema::drop('server_proc');
	}

}