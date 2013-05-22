<?php namespace Admin\Models\User;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Laravel\Validator as Validator,
	Laravel\Auth as Auth,
	Datagrid as Datagrid;
	
class Role extends Eloquent {

	public static $timestamps = true;
	public static $table = 'users_roles';
	public static $key = 'roleid';
	
	public function user()
	{
		return $this->belongs_to('Admin\Models\User\User');
	}

	public static function listRole(){

		$rolelist = Role::all();

		$datagrid = new Datagrid;
		$datagrid->setFields(array('role'=>'Role','roledesc'=>'Role Description'));
		$datagrid->setAction('edit','editRoleModal',true,array('roleid'));//false,array('id'=>'roleid','data-toggle'=>'modal'));
		$datagrid->setAction('delete','deleteRole',true,array('roleid'));
		$datagrid->setContainer('list01','span12');
		$datagrid->setTable('users','table table-bordered table-hover table-striped table-condensed');
		$datagrid->build($rolelist,'roleid');

		return $datagrid->render();

	}

	public function acl()
	{

		return $this->has_many('Admin\Models\User\Acl', 'roleid');
	}

	public static function arrayRoles()
	{
		$rolelist = Role::all();

		$arrayRole = array();

		foreach ($rolelist as $value) {
			if(Auth::check() && Auth::user()->role != 1 &&  $value->roleid != 1){
				$arrayRole[$value->roleid] = $value->role;
			}else{
				$arrayRole[$value->roleid] = $value->role;
			}
		}

		return $arrayRole;
	}

}