<?php

class Claims_App extends Eloquent
{
	public static $timestamps = true;
	public static $table = 'claims';
	public static $key = 'claimid';
	

	public static function applyclaims($input){

            // $user = Claims_App::find($id);
            $user = new Claims_App;

            $refno = 'MC'.Str::upper(Str::random(4, 'alpha')).time();

            // $user->claimscat  = $input['claimscat'];
            // $user->claimsref  = $refno;
            // $user->userid  = Auth::user()->userid;
            // $user->flowid = $input['claimscat'];
            // $user->applydate = date('Y-m-d',strtotime($input['applydate']));
            // $user->applymonth = $input['applymonth'];
            // $user->save();

            try{

                  $id = $user->insert_get_id(array(
                        'claimscat' => $input['claimscat'],
                        'flowid' => $input['claimscat'],
                        'claimsref'=> $refno,
                        'status'=> 1,
                        'userid'=>  Auth::user()->userid, 
                        'applydate'=>  date('Y-m-d',strtotime($input['applydate'])),  
                        'created_at'=>  date("Y-m-d H:i:s"), 
                        'updated_at'=>  date("Y-m-d H:i:s"),
                        'applymonth'=>  $input['applymonth']));


                 Log::write('Claims', 'Claims Application '.$refno.' successfully created');

                 return $id;

            }catch(Exception $e) {
                Log::write('Claims', 'Claims Application not success');
            }


      }

      public function claimcategory()
      {
        return $this->belongs_to('Data_Claims_Cat','claimscat');
      }

      public static function appInfo($appID){

            $catData = Claims_App::left_join('data_claims_cat AS c', 'claims.claimscat', '=', 'c.claimcatid')
                        ->where('claimid','=',$appID)
                        ->left_join('data_status AS s', 'claims.status', '=', 's.statusid')
                        ->first(array('s.status_name', 'c.claims_cat_name', 'claims.*'));

            $data['category'] = $catData->claims_cat_name;
            $data['refno'] = $catData->claimsref;
            $data['applydate'] = date('d/m/Y H:m:s',strtotime($catData->created_at));
            $data['applymonth'] = $catData->applymonth;
            $data['status'] = $catData->status_name;

            return $data;

      }

}