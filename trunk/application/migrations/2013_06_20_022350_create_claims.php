<?php

class Create_Claims {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::create('claims', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('claimid');
		    $table->string('claimsref');
		    $table->integer('flowid');
		    $table->integer('userid');
		    $table->integer('claimscat');
		    $table->integer('status');
		    $table->date('submitdate');
		    $table->date('applydate');
		    $table->string('applymonth');
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
		Schema::drop('claims');
	}

}