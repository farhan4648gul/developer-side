<?php

class Create_Data_Status {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_status', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('statusid');
		    $table->string('status_name', 100);
		    $table->string('status_desc', 100);
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
		Schema::drop('data_status');
	}

}