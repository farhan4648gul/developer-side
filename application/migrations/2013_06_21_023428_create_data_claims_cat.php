<?php

class Create_Data_Claims_Cat {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_claims_cat', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('claimcatid');
		    $table->string('claims_cat_name', 100);
		    $table->string('claims_cat_desc', 100);
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
		Schema::drop('data_claims_cat');
	}

}