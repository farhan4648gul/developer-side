<?php

class Admin_Create_Module {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('moduls', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('modulid');
		    $table->string('modulname', 100);
		    $table->string('modulalias', 100);
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
		Schema::drop('moduls');
	}

}