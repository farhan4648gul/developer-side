<?php

class Navigations_Pages {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('navigation_pages', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('navpageid');
		    $table->integer('navheaderid');
		    $table->integer('parentid');
		    $table->integer('parentstep');
		    $table->integer('modulpageid');
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
		Schema::drop('navigation_pages');
	}

}