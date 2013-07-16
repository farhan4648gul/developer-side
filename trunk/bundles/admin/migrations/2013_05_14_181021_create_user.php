<?php

class Admin_Create_User {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('users', function($table) {

			$table->engine = 'InnoDB';
			
		    $table->increments('userid');
		    $table->string('username', 50);
		    $table->string('password',100);
		    $table->integer('role');
		    $table->string('validationkey',100);
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
		Schema::drop('users');
	}

}