<?php namespace Admin\Models\Data;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Datagrid;

class Group extends Eloquent {

	public static $timestamps = true;
    public static $table = 'data_group';
    public static $key = 'dmid';

    public static function listData(){

        $allGroup = Group::all();

        $datagrid = new Datagrid;
        $datagrid->setFields(array('group_name' =>'Data Group'));
        $datagrid->setAction('manage','datacontent',false);
        $datagrid->setAction('edit','deleteRole',true,array('dmid'));
        $datagrid->setAction('delete','deleteRole',true,array('dmid'));
        $datagrid->setTable('dataGroup','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allGroup,'dmid');

        return $datagrid->render();

    }

    public static function getDataModel($groupClass){

    	$model = new $groupClass;

    	return $model; 

    }

    public static function setDataInput($groupClass,$input){

    	try{

    		$groupClass::setData($input);

    	}catch(Exception $e) {
                Log::write('Data', 'Data Insertion Not Success');
        }

    }

    public static function remDataInput($groupClass,$dataId){

    	try{

    		$groupClass::remData($dataId);

    	}catch(Exception $e) {
                Log::write('Data', 'Data Removal Not Success');
        }

    }

    public static function getDataList($groupClass){

    	return $groupClass::listData();
    }

}