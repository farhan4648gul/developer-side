<?php

class Admin_Create_Flow {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flows', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('flowid');
		    $table->string('flowname', 100);
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
		Schema::drop('flows');
	}

}