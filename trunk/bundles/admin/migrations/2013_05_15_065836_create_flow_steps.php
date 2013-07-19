<?php

class Admin_Create_Flow_Steps {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flows_steps', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('stepid');
		    $table->integer('flowid');
		    $table->string('step', 100);
		    $table->integer('roleid');
		    $table->integer('parentid');
		    $table->integer('state');
		    $table->integer('page');
		    $table->integer('condition2');
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
		Schema::drop('flows_steps');
	}

}