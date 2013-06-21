<?php

class Create_Data_Dash {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_group', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('dmid');
		    $table->string('group_name', 100);
		    $table->string('group_model', 100);
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
		Schema::drop('data_group');
	}

}