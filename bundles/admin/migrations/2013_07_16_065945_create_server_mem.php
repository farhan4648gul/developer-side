<?php

class Admin_Create_Server_Mem {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_mem', function($table) {

			$table->engine = 'InnoDB';

		    $table->increments('mem_id');
		    $table->integer('server_id');
		    $table->string('mem_kbmemfree', 100);
		    $table->string('mem_kbmemused', 100);
		    $table->string('mem_kbbuffers', 100);
		    $table->string('mem_kbcached', 100);
		    $table->string('mem_kbswpfree', 100);
		    $table->string('mem_kbswpused', 100);
		    $table->string('mem_swpused', 100);
		    $table->string('mem_kbswpcad', 100);
		    $table->date('mem_date');
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
		Schema::drop('server_mem');
	}

}