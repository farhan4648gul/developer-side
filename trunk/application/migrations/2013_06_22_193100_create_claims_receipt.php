<?php

class Create_Claims_Receipt {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('claims_receipts', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('claimrecid');
		    $table->integer('claimid');
		    $table->integer('claimdetailid');
		    $table->string('recpath');
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
		Schema::drop('claims_receipts');
	}

}