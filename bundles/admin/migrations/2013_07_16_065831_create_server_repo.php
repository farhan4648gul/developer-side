<?php

class Admin_Create_Server_Repo {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_repo', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('server_id');
		    $table->string('server_name', 100);
		    $table->string('server_ip', 100);
		    $table->string('group_key', 100);
		    $table->date('server_date');
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
		Schema::drop('server_repo');
	}

}