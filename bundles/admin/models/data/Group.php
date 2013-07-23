<?php namespace Admin\Models\Data;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Datagrid, Laravel\Config as Config,
    Laravel\Database as DB,Laravel\Log,Laravel\Str,Laravel\Lang;

class Group extends Eloquent {

	public static $timestamps = true;
    public static $table = 'data_group';
    public static $key = 'dmid';

    public static function listData(){

        $allGroup = Group::paginate(Config::get('system.pagination'));

        $datagrid = new Datagrid;
        $datagrid->setFields(array('group_name' => Str::upper(Lang::line('admin.datagroup')->get())));
        $datagrid->setAction(Lang::line('global.manage')->get(),'datacontent',false);
        $datagrid->setAction(Lang::line('global.edit')->get(),'editGroup',true,array('dmid'));
        $datagrid->setAction(Lang::line('global.delete')->get(),'deleteGroup',true,array('dmid','group_name'));
        $datagrid->setTable('dataGroup','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allGroup,'dmid');

        return $datagrid->render();

    }

    public static function getGroupinfo($groupID){

        $dataGroup = Group::find($groupID);

        $data['groupid'] = $dataGroup->dmid;
        $data['group_name'] = $dataGroup->group_name;
        $data['group_model'] = $dataGroup->group_model;
        $data['group_key'] = $dataGroup->group_key;

        return $data;
    }

    public static function getDataModel($groupID){

        $dataGroup = Group::find($groupID);

        Content::$table = $dataGroup->group_model;
        Content::$key = $dataGroup->group_key;
        Content::$timestamps = 'true';
        Content::$header = $dataGroup->group_name;

    }


    public static function setDataInput($input){

    	try{

    		Content::setData($input);

    	}catch(Exception $e) {
                Log::write('Data', 'Data Insertion Not Success');
        }

    }

    public static function remDataInput($dataId){

    	try{

    		Content::remData($dataId);

    	}catch(Exception $e) {
                Log::write('Data', 'Data Removal Not Success');
        }

    }

    public static function getDataList(){

        return Content::genListData();
    }

    public static function getDataInfo($id){

        return Content::getInfo($id);
    }

    public static function getDataHeader(){

        return Content::$header;
    }


    /**
     * Check Existing Data
     *
     * @return void
     * @author 
     **/
    public static function checkData($table = NULL){
        
        $existTable = DB::query("show tables like '".Content::$table."'");

        if(empty($existTable)) return false;

        $table = ($table != NULL)?$table:Content::$table;
        $count = DB::table($table)->count();

        return ($count>0)?true:false;

    }

    /**
     * Check Existing table
     *
     * @return void
     * @author 
     **/
    public static function checkTable($table,$field){

        $existTable = DB::query("show tables like '".$table."'");
        $tableCol = DB::query("show columns from ".$table." like '".$field."'");

        return (!empty($existTable) && !empty($tableCol))?true:false;

    }

}