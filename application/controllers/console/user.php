<?php

/*********************************************************************
*  Module : Admin
*  Controller : User
*  Function : 
*  Author :  joharijumali
*  Description: Class for User Management Module
**********************************************************************/

class Console_User_Controller extends Base_Controller {

    public $restful = true;

    public function get_index(){
        return Redirect::to('admin/user/userlist');
    }


    public function post_resetpassword(){

        $input = Input::all();

        $user = Console_User::find(Auth::user()->userid);

        if( Hash::check($input['oldpassword'],$user->password) && $input['password'] == $input['repassword']){

            if(isset($input['username']) && $input['username'] != NULL){
                $user->username = $input['username'];
            }
            $user->password = Hash::make($input['password']);
            $user->save();

        }

    }

    public function get_profile()
    {

        $profile = Console_Profile::loggedprofile();

        return $profile;

    }


    public function post_profile()
    {

        $input = Input::all();

        $profile = Console_Profile::find(Auth::user()->userid);
        $profile->fullname  = $input['fullname'];
        $profile->emel = $input['emel'];
        $profile->icno = $input['icno'];

        $profile->save();

        $profile = Console_Profile::loggedprofile();

        return $profile;

    }


}

?>