<?php

class Create_User_Profile {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_profiles', function($table) {

			$table->engine = 'InnoDB';
			
		    $table->increments('profileid');
		    $table->integer('userid');
		    $table->string('fullname', 100);
		    $table->string('icno',20);
		    $table->string('emel',50);
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
		Schema::drop('users_profiles');
	}

}