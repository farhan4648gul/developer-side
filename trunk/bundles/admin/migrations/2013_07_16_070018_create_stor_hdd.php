<?php

class Admin_Create_Stor_Hdd {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stor_hdd', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('hdd_id');
		    $table->integer('server_id');
		    $table->string('hdd_name', 100);
		    $table->string('hdd_free', 100);
		    $table->string('hdd_total', 100);
		    $table->string('hdd_rrqms', 100);
		    $table->string('hdd_wrqms', 100);
		    $table->string('hdd_rs', 100);
		    $table->string('hdd_ws', 100);
		    $table->string('hdd_rMBs', 100);
		    $table->string('hdd_wMBs', 100);
		    $table->string('hdd_avgrq', 100);
		    $table->string('hdd_avgqu', 100);
		    $table->string('hdd_await', 100);
		    $table->string('hdd_svctm', 100);
		    $table->string('hdd_util', 100);
		    $table->date('hdd_date');
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
		Schema::drop('stor_hdd');
	}

}