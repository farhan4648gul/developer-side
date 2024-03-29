<?php

class Admin_Admin_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function($table)
        {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('username', 32)->unique();
            $table->string('password', 64);
            $table->timestamps();
        });	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('admins');
	}

}