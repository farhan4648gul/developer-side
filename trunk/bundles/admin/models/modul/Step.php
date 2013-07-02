<?php namespace Admin\Models\Modul;
use \Laravel\Database\Eloquent\Model as Eloquent, 
	Datagrid,
	Admin\Models\Modul\Flow as Flow;

class Step extends Eloquent {

    public static $timestamps = true;
    public static $table = 'flows_steps';
    public static $key = 'stepid';


    public static function listSteps($flowid){

        $flowSteps = Step::left_join('users_roles AS r', 'flows_steps.roleid', '=', 'r.roleid')
        			->where('flowid','=',$flowid)
        			->paginate(10,array('r.role', 'flows_steps.*'));

        $datagrid = new Datagrid;
        $datagrid->setFields(array('step' =>'Step'));
        $datagrid->setFields(array('role' =>'Action By'));
        $datagrid->setFields(array('next' =>'Next Action'));
        $datagrid->setFields(array('condition1' =>'Condition Action 1'));
        $datagrid->setFields(array('condition2' =>'Condition Action 2'));
        // $datagrid->setFields(array('created_at' =>'Created'));
        // $datagrid->setFields(array('updated_at' =>'Updated'));
        $datagrid->setAction('edit','editStep',true,array('stepid'));
        $datagrid->setAction('delete','deleteStep',true,array('stepid'));
        $datagrid->setTable('steps','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($flowSteps,'stepid');

        return $datagrid->render();
    }

    public function role(){
    	return $this->has_one('Admin\Models\User\Role','roleid');
    }

	public static function arraySteps()
	{
		$steplist = Step::all();

		$arraySteps = array();
		$arraySteps[0] = 'Choose Steps';
		foreach ($steplist as $value) {
			$arraySteps[$value->stepid] = $value->step;
		}

		return $arraySteps;
	}

}