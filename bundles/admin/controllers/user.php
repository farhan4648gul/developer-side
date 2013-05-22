<?php

use Admin\Models\User\User as User,
    Admin\Models\User\Role as Role,
    Admin\Models\User\Profile as Profile,
    Message as Message,
    Laravel\Str as Str,
    Laravel\Log as Log,
    Laravel\Input as Input;

/**
 * Admin User class
 *
 * @package default
 * @author joharijumali@gmail.com
 **/


class Admin_User_Controller extends Admin_Base_Controller {

	public $restful = true;

    public function get_index(){

    	return View::make('admin::user.index');

    }

    public function get_list(){

        $data['userlist'] = User::listUser();
        $data['allrole'] = Role::arrayRoles();

    	return View::make('admin::user.list',$data);

    }

    /**
     * User Registration function
     * Component : register
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/

    public function post_register()
    {   
        $input = Input::all();

        $input['key'] = $key = Str::random(32, 'alpha');

        // $validation = User::validate($input);
        // $validateProfile = UserProfile::validate($input);

        // if( $validation->fails()) {
        //     return Redirect::to('auth/register')->with_errors($validation)->with_input();
        // }elseif($validateProfile->fails()){
        //     return Redirect::to('auth/register')->with_errors($validateProfile)->with_input();
        // }

       $resgisteredUser = User::registerUser($input);

       if($resgisteredUser){

            try{

                $mailer = Message::to($input['emel']);
                $mailer->from('admin@3fresorces.com', 'System Generate');
                $mailer->subject('User Registration Confirmation');
                $mailer->body('view: admin::plugin.email');
                $mailer->body->username = $input['username'];
                $mailer->body->password = $input['password'];
                $mailer->body->key = $key ;
                $mailer->html(true);
                $mailer->send();

                Log::write('email', 'Message was to  '.$input['emel'].' was sent.');

            }catch (Exception $e) {
                Log::write('email', 'Message was to  '.$input['emel'].' not sent.');
                Log::write('email', 'Mailer error: ' . $e->getMessage());
            }

           return User::listUser();
       }

    }

    /**
     * User Reset login function
     * Component : resetlogin
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/

    public function post_resetlogin(){

        $validatekey = Str::random(32, 'alpha');

        $uname = Str::random(16, 'alpha');

        $user = User::find(Auth::user()->userid);
        $user->username = $uname;
        $user->password = $uname;
        $user->status = 3;
        $user->validationkey = $validatekey;
        $user->save();

        Log::write('User', 'Reset Login User ' . $user->userprofile->icno);

        try{

            $mailer = Message::to($user->userprofile->emel);
            $mailer->from('admin@3fresources.com', 'System Generate');
            $mailer->subject('Account Reset');
            $mailer->body('view: admin::plugin.emailAccReset');
            $mailer->body->username = $uname;
            $mailer->body->password = $uname;
            $mailer->body->key = $key ;
            $mailer->html(true);
            $mailer->send();

        }catch (Exception $e) {
            Log::write('email', 'Message was to '.$user->userprofile->emel.' not sent.');
            Log::write('email', 'Mailer error: ' . $e->getMessage());
        }

    }

    /**
     * User Reset password function
     * Component : resetpassword
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/

    public function post_resetpassword(){

        $input = Input::all();

        $user = User::find(Auth::user()->userid);

        if( Hash::check($input['oldpassword'],$user->password) && $input['password'] == $input['repassword']){

            $user->password = Hash::make($input['password']);
            $user->save();

            Log::write('User', 'Reset Password User ' . $user->userprofile->icno);

        }

    }

    /**
     * User Profile function
     * Component : profile
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/

    public function get_profile()
    {

        $profile = Profile::loggedprofile();

        return $profile;

    }

    public function post_profile()
    {

        $input = Input::all();

        // $validation = Admin_UserProfile::validate($input);

        // if( $validation->fails() ) {
        //     return Redirect::to('user/profile')->with_errors($validation)->with_input();
        // }

        // $extension = File::extension($input['photo']['name']);
        // $directory = path('public').'avatar/'.sha1(Auth::user()->userid);
        // $filename = sha1(Auth::user()->userid.time()).".{$extension}";


        $profile = Profile::find(Auth::user()->userid);

        // if($input['photo']['size'] != null){
        //     $upload_success = Input::upload('photo', $directory, $filename);

        //     if( $upload_success ) {

        //         while(is_file('public/'.$profile->imgpath) == TRUE)
        //         {
        //             chmod('public/'.$profile->imgpath, 0666);
        //             unlink('public/'.$profile->imgpath);
        //         }

        //         $profile->imgpath = 'avatar/'.sha1(Auth::user()->userid).'/'.$filename;
        //     }
        // }

        $profile->fullname  = $input['fullname'];
        $profile->dob  = date('Y-m-d',strtotime($input['dob']));
        $profile->address = $input['address'];
        $profile->postcode = $input['postcode'];
        $profile->emel = $input['emel'];
        $profile->town = $input['town'];
        $profile->city = $input['city'];
        $profile->icno = $input['icno'];

        $profile->save();

        Log::write('User', 'Update Profile User ' . $profile->icno);

        $profile = Profile::loggedprofile();

        return $profile;

    }

    /**
     * User Role function
     * Component : role,roleinfo,deleterole
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/


    public function get_role(){

        $data['rolelist'] = Role::listRole();
    	return View::make('admin::user.role',$data);

    }

    public function post_role(){

        $input = Input::get();

        if($input['roleid'] == NULL):
            $logs = 'Add New Role ';
            $role = new Role;
        else:
            $role = Role::find($input['roleid']);
            $logs = 'Edit Role ';
        endif;
        $role->role  = Str::title($input['role']);
        $role->roledesc  = $input['roledesc'];
        $role->timestamp();
        $role->save();

        Log::write('User', $logs.$input['role'].' by '.Auth::user()->username);

        return Role::listRole();

    }

    public function get_roleinfo(){
        $input = Input::get();

        $role = Role::find($input['roleid']);
        
        $data['role'] = $role->role;
        $data['roledesc'] = $role->roledesc;
        $data['roleid'] = $role->roleid;

        return json_encode($data);
    }

    public function post_deleterole(){
        $input = Input::get();

        Log::write('User', 'Delete Role ID '.$input['id'].' by '.Auth::user()->username);

        // Role::find($input['id'])->acl()->delete();
        Role::find($input['id'])->delete();

        return Role::listRole();
    }

}// END class 