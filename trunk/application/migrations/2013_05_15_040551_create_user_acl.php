<?php

class Create_User_Acl {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_acls', function($table) {

			$table->engine = 'InnoDB';
			
		    $table->increments('aclid');
		    $table->integer('roleid');
		    $table->string('modul',50);
		    $table->string('controller',50);
		    $table->string('action',50);
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
		Schema::drop('users_acls');
	}

}