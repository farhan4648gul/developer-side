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
        $dataGroup->group_model  = $input['group_model'];
        $dataGroup->group_key  = $input['group_key'];
        $dataGroup->save();

		return Group::listData();
	}

	public function post_datainput(){

        $input = Input::get();

        Group::getDataModel($input['groupid']);

		Group::setDataInput($input);

		return Group::getDataList();
	}

	public function post_dataremove(){

        $input = Input::get();

        Group::getDataModel($input['groupid']);

		Group::remDataInput($input['id']);

		return Group::getDataList();
	}

    public function get_datainfo(){

        $input = Input::get();

        Group::getDataModel($input['groupid']);

        $data = Group::getDataInfo($input['id']);

        return json_encode($data);
    }

	public function get_datacontent(){

		$groupID = URI::segment(4);

		Group::getDataModel($groupID);

		$data['list'] = Group::getDataList();
		$data['groupID'] = $groupID;
		$data['header'] = Group::getDataHeader();

		return View::make('admin::data.data',$data);

	}

}// END class 