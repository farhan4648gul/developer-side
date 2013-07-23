<?php namespace Admin\Models\Modul;
use \Laravel\Database\Eloquent\Model as Eloquent, 
	Datagrid,
	Admin\Models\Modul\Flow as Flow,Laravel\Config;

class Step extends Eloquent {

    public static $timestamps = true;
    public static $table = 'flows_steps';
    public static $key = 'stepid';


    public static function listSteps($flowid){

        $flowSteps = Step::left_join('users_roles AS r', 'flows_steps.roleid', '=', 'r.roleid')
        			->where('flowid','=',$flowid)
        			->paginate(Config::get('system.pagination'),array('r.role', 'flows_steps.*'));

        $datagrid = new Datagrid;
        $datagrid->setFields(array('step' =>'Step'));
        $datagrid->setFields(array('role' =>'Action By'));
        $datagrid->setFields(array('next' =>'Next Action'));
        $datagrid->setFields(array('condition1' =>'Condition Action 1'));
        $datagrid->setFields(array('condition2' =>'Condition Action 2'));
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

    public static function steploop($flowid){

        $trees = array();
        $first = Step::where('parentid','=',0)->where('flowid','=',$flowid)->get();

        if($first){
            foreach ($first as $value) {
                if(!empty($value)){
                    $trees[$value->stepid]['desc'] = $value->step;
                    $trees[$value->stepid]['child'] = self::looper($value->stepid,$flowid);
                }
            }
        }

        return $trees;

    }

    protected static function looper($id,$flowid){

        $trees = array();
        $child = Step::where('parentid','=',$id)->where('flowid','=',$flowid)->get();

        foreach ($child as $cvalue) {
            if(!empty($cvalue)){
                $trees[$cvalue->stepid]['desc'] = $cvalue->step;
                $trees[$cvalue->stepid]['child'] = self::looper($cvalue->stepid,$flowid);
            }
        }

        return $trees;

    }

}