<?php

use Admin\Models\Data\Group as Group,
    Logger as Logger,
    Admin\Libraries\Crapcrush as Crapcrush;

/**
 * System Data Management Modul class
 *
 * @package default
 * @author joharijumali@gmail.com
 **/

class Admin_Data_Controller extends Admin_Base_Controller {


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function get_board()
	{

		$data['model'] = Crapcrush::dataModeling();

		$data['datalist'] = Group::listData();

		return View::make('admin::data.board',$data);
	}

	public function post_datagroup(){

        $input = Input::get();

        // if($input['roleid'] == NULL):
        $dataGroup = new Group;
        // else:
        //  $role = Admin_UserRole::find($input['roleid']);
        // endif;
        $dataGroup->group_name  = Str::upper($input['group_name']);
        $dataGroup->group_model  = str_replace('"','',str_replace('/', '"\"', $input['group_model']));
        $dataGroup->save();

		return Group::listData();
	}

	public function post_datainput(){

        $input = Input::get();

        $dataGroup = Group::find($input['groupID']);

		Group::setDataInput($dataGroup->group_model,$input);

		return Group::getDataList($dataGroup->group_model);
	}

	public function post_dataremove(){

        $input = Input::get();

        $dataGroup = Group::find($input['groupid']);

		Group::remDataInput($dataGroup->group_model,$input['id']);

		return Group::getDataList($dataGroup->group_model);
	}

    public function get_datainfo(){

        $input = Input::get();

        $dataGroup = Group::find($input['groupid']);

        $model = Group::getDataModel($dataGroup->group_model);

        $data = $model::getInfo($input['id']);

        return json_encode($data);
    }

	public function get_datacontent(){

		$groupID = URI::segment(4);

		$dataGroup = Group::find($groupID);

		// $data = Group::getDataModel($dataGroup->group_model);

		$data['list'] = Group::getDataList($dataGroup->group_model);
		$data['groupID'] = $groupID;
		$data['header'] = $dataGroup->group_name;

		return View::make('admin::data.data',$data);

	}

}// END class 