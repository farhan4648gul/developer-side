<?php namespace Admin\Models\User;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Laravel\Validator as Validator,
	Datagrid as Datagrid,
    Laravel\Hash as Hash,
    Laravel\Log as Log,
	Admin\Models\User\Profile as Profile;

class User extends Eloquent {

    public static $timestamps = false;
    public static $table = 'users';
    public static $key = 'userid';

    public static $rules = array( 
                                'username' => 'required|unique:users', 
                                'password' => 'required', 
                                'role' => ''
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

        $allUser = User::where('role','<>','1')->get();

        $datagrid = new Datagrid;
        $datagrid->setFields(array('userprofile/fullname' =>'Fullname'));
        $datagrid->setFields(array('userprofile/emel' =>'Email'));
        $datagrid->setFields(array('userprofile/icno' =>'IC Number'));
        $datagrid->setFields(array('status' =>'Status'));
        $datagrid->setAction('view','deleteRole',true,array('userid'));
        $datagrid->setAction('reset','deleteRole',true,array('userid'));
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


}