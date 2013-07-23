<?php

class Console_User extends Eloquent
{
    public static $timestamps = true;
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
        return $this->has_one('Console_Profile','userid');
    }

    public function roles()
    {
        return $this->has_one('Console_Role','roleid');
    }

    public static function confirmUser($input,$id = 0){

        if($id != 0){
            $user = Console_User::find($id);
            $user->username  = $input['username'];
            $user->password  = Hash::make($input['password']) ;
            $user->status = 1;
            $user->save();

            return true;
        }else{
            return false;
        }


    }

}
?>