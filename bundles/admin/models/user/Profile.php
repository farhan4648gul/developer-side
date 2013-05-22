<?php namespace Admin\Models\User;
use \Laravel\Database\Eloquent\Model as Eloquent,
	Laravel\Validator as Validator,
	Admin\Models\User\User as User;

class Profile extends Eloquent {

	public static $timestamps = false;
	public static $table = 'users_profiles';
	public static $key = 'profileid';
	public static $rules = array( 
				    		'fullname' => 'required', 
				    		'fullname' => 'required', 
				    		'emel' => 'required|email|unique:users_profiles', 
				    		'postcode' => 'required|Numeric'
				    	);

	
	public static function validate($data){
		return Validator::make($data, Static::$rules);
	}

     public function user()
     {
          return $this->belongs_to('Admin\Models\User\User');
     }

     public static function loggedprofile(){

     	$logged_user = Auth::user();
     	$userInfo = User::find($logged_user->userid)->userprofile;

        $data['profileid'] = $userInfo->profileid;
        $data['fullname'] = $userInfo->fullname;
        $data['icno'] = $userInfo->icno;
        $data['dob'] = $userInfo->dob;
        $data['emel'] = $userInfo->emel;
        $data['dob'] = $userInfo->dob;
        $data['address'] = $userInfo->address;
        $data['postcode'] = $userInfo->postcode;
        $data['town'] = $userInfo->town;
        $data['city'] = $userInfo->city;


        return json_encode($data);

     }

}