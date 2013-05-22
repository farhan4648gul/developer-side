<?php

class Create_User_Role {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('users_roles', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('roleid');
		    $table->string('role', 100);
		    $table->string('roledesc',100);
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
		Schema::drop('users_roles');
	}

}