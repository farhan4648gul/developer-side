<?php

class Create_Claims_Details {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('claims_details', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('claimdetailid');
		    $table->integer('claimid');
		    $table->string('detailmile');
		    $table->date('detaildate');
		    $table->string('detaildesc');
		    $table->string('detailfrom');
		    $table->string('detailto');
		    $table->string('detailtoll');
		    $table->string('detailpark');
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
		Schema::drop('claims_details');
	}

}