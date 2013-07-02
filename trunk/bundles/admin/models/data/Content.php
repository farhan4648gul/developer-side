<?php namespace Admin\Models\Data;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Datagrid, Laravel\Config as Config,
    Laravel\Database as DB,
    Laravel\Log as Log,
    Laravel\Auth as Auth;

/**
 * Data Content Model Class
 * 
 * Create model class for lookup data
 *
 * @package Admin\Model\Data
 * @author joharijumali@gmail.com
 **/

class Content extends Eloquent {

	public static $header = '';


	/**
	 * Generate Data datagrid table
	 *
	 * @return void
	 * @author 
	 **/
    public static function genListData(){

        $allContent = Content::paginate(10);

        $datagrid = new Datagrid;

        $tableCol = DB::query('show columns from '.Content::$table);

        foreach ($tableCol as $value) {
            if($value->field != 'created_at' && $value->field != 'updated_at' && $value->field != Content::$key){

	            if(stristr($value->field , 'name')){
	                $title = 'Data';
	            }elseif(stristr($value->field , 'desc')){
	        		$title = 'Description';
	            }else{
	            	$title = $value->field;
	            }

                $datagrid->setFields(array($value->field => $title));
            }
        }

        $datagrid->setAction('edit','editData',true,array(Content::$key));
        $datagrid->setAction('delete','deleteData',true,array(Content::$key));
        $datagrid->setTable('contentGroup','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allContent,Content::$key);

        return $datagrid->render();

    }

    /**
	 * Get Data information
	 *
	 * @return void
	 * @author 
	 **/
    public static function getInfo($id){

        $Category = Content::find($id);

        $tableCol = DB::query('show columns from '.Content::$table);

        $id = Content::$key;
        
        $data['id'] = $Category->$id;

        foreach ($tableCol as $value) {

        	$fieldname = $value->field;
            if(stristr($value->field , 'name')){
                $data['data'] = $Category->$fieldname;
            }elseif(stristr($value->field , 'desc')){
        		$data['description'] = $Category->$fieldname;
            }
        }

        return $data;
    }

    /**
	 * Add / Update Data information
	 *
	 * @return void
	 * @author 
	 **/
    public static function setData($input){

        $Category = ($input['id'] == NULL || !isset($input['id']))? new Content : Content::find($input['id']);

        $tableCol = DB::query('show columns from '.Content::$table);

        foreach ($tableCol as $value) {

        	$fieldname = $value->field;
            if(stristr($value->field , 'name')){
                $Category->$fieldname = $input['data'];
            }elseif(stristr($value->field , 'desc')){
        		$Category->$fieldname = $input['description'];
            }
        }

        $Category->save() ;

        $action = ($input['id'] == NULL || !isset($input['id']))? 'Insert':'<b>('.$input['id'].')</b> Update'; 

        Log::write('Data', 'Data <b>'.$input['data'].'</b> '.$action.' by '.Auth::user()->username);

    }

    /**
	 * Removing Data Information
	 *
	 * @return void
	 * @author 
	 **/
    public static function remData($id){

        Content::find($id)->delete();

        Log::write('Data', 'Data Id <b>'.$id.'</b> Remove by '.Auth::user()->username);

    }

}