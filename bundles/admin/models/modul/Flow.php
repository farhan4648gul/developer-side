<?php namespace Admin\Models\Modul;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Datagrid,Laravel\Config;

class Flow extends Eloquent {

    public static $timestamps = true;
    public static $table = 'flows';
    public static $key = 'flowid';

	public function steps(){
    
        return $this->has_many('Admin\Models\Modul\Step','flowid');
    }


    public static function listFlow(){

        $allFlow = Flow::paginate(Config::get('system.pagination'));

        $datagrid = new Datagrid;
        $datagrid->setFields(array('flowname' =>'Flow'));
        $datagrid->setFields(array('created_at' =>'Created'));
        $datagrid->setFields(array('updated_at' =>'Updated'));
        $datagrid->setAction('edit','editFlowModal',true,array('flowid'));
        // $datagrid->setAction('delete','deleteRole',true,array('userid'));
        $datagrid->setAction('step','step');
        $datagrid->setTable('flows','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allFlow,'flowid');

        return $datagrid->render();
    }

}