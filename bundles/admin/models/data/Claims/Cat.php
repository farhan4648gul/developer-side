<?php namespace Admin\Models\Data\Claims;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Datagrid,
    Laravel\Log as Log,
    Laravel\Auth as Auth;

class Cat extends Eloquent {

	public static $timestamps = true;
    public static $table = 'data_claims_cat';
    public static $key = 'claimcatid';

    public static function listData(){

        $allCat = Cat::all();

        $datagrid = new Datagrid;
        $datagrid->setFields(array('claims_cat_name' =>'Claims Category'));
        $datagrid->setFields(array('claims_cat_desc' =>'Description'));
        $datagrid->setAction('edit','editData',true,array('claimcatid'));
        $datagrid->setAction('delete','deleteData',true,array('claimcatid'));
        $datagrid->setTable('claimsCatGroup','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allCat,'claimcatid');

        return $datagrid->render();

    }

    public static function setData($input){

        $Category = ($input['id'] == NULL || !isset($input['id']))? new Cat : Cat::find($input['id']);
        $Category->claims_cat_name = $input['data'];
        $Category->claims_cat_desc = $input['description'];
        $Category->save() ;

        $action = ($input['id'] == NULL || !isset($input['id']))? 'Insert':'<b>('.$input['id'].')</b> Update'; 

        Log::write('Data', 'Claims Category <b>'.$input['data'].'</b> '.$action.' by '.Auth::user()->username);

    }

    public static function remData($id){

        Cat::find($id)->delete();

        Log::write('Data', 'Claims Category Id <b>'.$id.'</b> Remove by '.Auth::user()->username);

    }

    public static function getInfo($id){

        $Category = Cat::find($id);
        
        $data['id'] = $Category->claimcatid;
        $data['data'] = $Category->claims_cat_name;
        $data['description'] = $Category->claims_cat_desc;

        return $data;
    }


}