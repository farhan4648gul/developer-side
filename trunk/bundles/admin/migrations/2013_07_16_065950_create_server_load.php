<?php

class Admin_Create_Server_Load {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_load', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('load_id');
		    $table->integer('server_id');
		    $table->string('load_one', 100);
		    $table->string('load_five', 100);
		    $table->string('load_fifteen', 100);
		    $table->string('load_fifteen', 100);
		    $table->string('load_uptime', 100);
		    $table->string('load_user', 100);
		    $table->date('load_date');
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
		Schema::drop('server_load');
	}

}