<?php namespace Admin\Models\User;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Laravel\Validator as Validator,
	Datagrid as Datagrid,
    Laravel\Hash as Hash,
    Laravel\Log as Log,
    Laravel\Auth as Auth,
	Admin\Models\User\Profile as Profile,Laravel\Str,Laravel\Lang,Laravel\Config;

class User extends Eloquent {

    public static $timestamps = false;
    public static $table = 'users';
    public static $key = 'userid';

    public static $rules = array( 
                                'username' => 'required|unique:users', 
                                'password' => 'required',
                            );

    
    public static function validate($data){
        return Validator::make($data, Static::$rules);
    }

    public function userprofile()
    {
        return $this->has_one('Admin\Models\User\Profile','userid');
    }

    public function roles()
    {
        return $this->has_one('Admin\Models\User\Role','roleid');
    }
    
    public static function listUser(){

        $allUser = User::where('role','<>','0')->paginate(Config::get('system.pagination'));

        $datagrid = new Datagrid;
        $datagrid->setFields(array('userprofile/fullname' => Str::upper(Lang::line('admin.fullname')->get())));
        $datagrid->setFields(array('userprofile/emel' => Str::upper(Lang::line('admin.activeemel')->get())));
        $datagrid->setFields(array('userprofile/icno' => Str::upper(Lang::line('admin.idno')->get())));
        $datagrid->setFields(array('status' => Str::upper('Status')));
        $datagrid->setAction(Lang::line('global.edit')->get(),'viewUser',true,array('userid'));
        $datagrid->setAction(Lang::line('global.delete')->get(),'deleteAccount',true,array('userid','userprofile/fullname'));
        $datagrid->setAction(Lang::line('global.reset')->get(),'resetAccount',true,array('userid'));
        $datagrid->setTable('users','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allUser,'userid');

        return $datagrid->render();

    }    

    public static function userSearchList($input){

        $operator = (stripos($input['searchval'], '*'))? 'LIKE':'=' ;
        $val = str_replace("*", "", $input['searchval']);
        $refval = (stripos($input['searchval'], '*'))? '%'.$val.'%':$val ;

        $allUser = User::left_join('users_profiles', 'users.userid', '=', 'users_profiles.userid')
                    ->where('icno', $operator, $refval)
                    ->or_where('fullname', $operator, $refval)
                    ->paginate(Config::get('system.pagination'));

        $datagrid = new Datagrid;
        $datagrid->setFields(array('userprofile/fullname' => Str::upper(Str::title(Lang::line('admin.fullname')->get()))));
        $datagrid->setFields(array('userprofile/emel' => Str::upper(Str::title(Lang::line('admin.activeemel')->get()))));
        $datagrid->setFields(array('userprofile/icno' => Str::upper(Str::title(Lang::line('admin.idno')->get()))));
        $datagrid->setFields(array('status' => Str::upper('Status')));
        $datagrid->setAction(Lang::line('global.edit')->get(),'viewUser',true,array('userid'));
        $datagrid->setAction(Lang::line('global.delete')->get(),'deleteAccount',true,array('userid'));
        $datagrid->setAction(Lang::line('global.reset')->get(),'resetAccount',true,array('userid'));
        $datagrid->setTable('users','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allUser,'userid');

        return $datagrid->render();

    }

    public static function registerUser($input){

        $User = new User;
        $id = $User->insert_get_id(array('username' => $input['username'],
                                        'password'=> Hash::make($input['password']) , 
                                        'validationkey'=>  $input['key'], 
                                        'created_at'=>  date("Y-m-d H:i:s"), 
                                        'updated_at'=>  date("Y-m-d H:i:s"), 
                                        'status'=>  3, // 1 = active, 2=pendingc confirmation 3=unactive 
                                        'role'=>$input['role']));

        unset($input['username']);
        unset($input['password']);
        unset($input['role']);
        unset($input['key']);

        if($id){

        // $extension = File::extension($input['imgpath']['name']);
        // $directory = path('public').'avatar/'.sha1($id);
        // $filename = sha1($id.time()).".{$extension}";

        // if($input['imgpath']['size'] != null){

        //     $upload_success = Input::upload('photo', $directory, $filename);

        //     if( $upload_success ) {
        //         $input['imgpath'] = 'avatar/'.sha1($id).'/'.$filename;
        //     }else{
        //         $input['imgpath'] = '';
        //     }
        // }else{
        //     $input['imgpath'] = '';
        // }

            $profile = new Profile(array(
                'fullname' => $input['fullname'],
                'icno' => $input['icno'],
                'created_at'=>  date("Y-m-d H:i:s"), 
                'updated_at'=>  date("Y-m-d H:i:s"),
                'emel' => $input['emel']
            ));

            $user = User::find($id);
            $user->userprofile()->insert($profile);  

            Log::write('User', 'User '.$input['icno'].' registered');

            return $profile->exists; 

        }else{

            Log::write('User', 'User '.$input['icno'].' failed registered');
            return false;
        }   

        
    }

     public static function userinfo($id){

        $userInfo = User::find($id);

        $profile = $userInfo->userprofile;

        $role = $userInfo->roles;

        $data['username'] = $userInfo->username;
        $data['fullname'] = $profile->fullname;
        $data['icno'] = $profile->icno;
        $data['emel'] = $profile->emel;
        $data['role'] = $userInfo->role;
        $data['status'] = $userInfo->status;
        $data['userid'] = $userInfo->userid;

        return $data;

     }

     public static function updateUser($input){

        $user = User::find($input['userid']);
        $profileid = $user->userprofile->profileid;
        $user->role = $input['role'];
        $user->status = $input['status'];
        $user->save();

        $prof = array(array('fullname' => $input['fullname'],
                    'icno' => $input['icno'],
                    'emel' => $input['emel'],
                ));

        $profile = Profile::find($profileid);
        $profile->fullname = $input['fullname'];
        $profile->icno = $input['icno'];
        $profile->emel = $input['emel'];
        $profile->save();

        $profile = User::find($input['userid']);

        Log::write('User', 'Update User ' . $user->userprofile->icno. 'By '.Auth::user()->username);

     }


}