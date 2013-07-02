<?php namespace Admin\Models\Data;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Datagrid,
    Laravel\Log as Log,
    Laravel\Str as Str,
    Laravel\Auth as Auth;

class Status extends Eloquent {

	public static $timestamps = true;
    public static $table = 'data_status';
    public static $key = 'statusid';

    public static function listData(){

        $allCat = Status::paginate(10);

        $datagrid = new Datagrid;
        $datagrid->setFields(array('status_name' =>'Status'));
        $datagrid->setFields(array('status_desc' =>'Description'));
        $datagrid->setAction('edit','editData',true,array('statusid'));
        $datagrid->setAction('delete','deleteData',true,array('statusid'));
        $datagrid->setTable('statusTable','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allCat,'statusid');

        return $datagrid->render();

    }

    public static function setData($input){

        $Category = ($input['id'] == NULL || !isset($input['id']))? new Status : Status::find($input['id']);
        $Category->status_name = Str::title($input['data']);
        $Category->status_desc = $input['description'];
        $Category->save() ;

        $action = ($input['id'] == NULL || !isset($input['id']))? 'Insert':'<b>('.$input['id'].')</b> Update';   

        Log::write('Data', 'Status <b>'.$input['data'].'</b> '.$action.' by '.Auth::user()->username);

    }

    public static function remData($id){

        Status::find($id)->delete();

        Log::write('Data', 'Status Id <b>'.$id.'</b> Remove by '.Auth::user()->username);

    }

    public static function getInfo($id){

        $Category = Status::find($id);
        
        $data['id'] = $Category->statusid;
        $data['data'] = $Category->status_name;
        $data['description'] = $Category->status_desc;

        return $data;
    }


}