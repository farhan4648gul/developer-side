<?php

class Console_Role extends Eloquent
{
	public static $timestamps = true;
	public static $table = 'users_roles';
	public static $key = 'roleid';
	
	public function user()
	{
		return $this->belongs_to('Console_User');
	}


}
