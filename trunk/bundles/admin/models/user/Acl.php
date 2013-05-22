<?php namespace Admin\Models\User;
use \Laravel\Database\Eloquent\Model as Eloquent;

class Acl extends Eloquent {

	public static $timestamps = false;
	public static $table = 'users_acls';
	public static $key = 'aclid';

}