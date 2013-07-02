<?php namespace Admin\Models\Data;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Datagrid, Laravel\Config as Config,
    Laravel\Database as DB;

class Group extends Eloquent {

	public static $timestamps = true;
    public static $table = 'data_group';
    public static $key = 'dmid';

    public static function listData(){

        $allGroup = Group::paginate(10);

        $datagrid = new Datagrid;
        $datagrid->setFields(array('group_name' =>'Data Group'));
        $datagrid->setAction('manage','datacontent',false);
        $datagrid->setAction('edit','deleteRole',true,array('dmid'));
        $datagrid->setAction('delete','deleteRole',true,array('dmid'));
        $datagrid->setTable('dataGroup','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allGroup,'dmid');

        return $datagrid->render();

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

}