<?php

use Data_Claims_Cat as Cat;

class Claims_Request_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{
		$data['claimlist'] = Claims_App::listClaims();

		return View::make('claims.request.index',$data);
	}

	/*
	* Claims application form
	*/
	public function get_request()
	{

		$data['claimsCat'] = Cat::arrayCats();
        $data['claimlist'] = Claims_App::listClaims();

		return View::make('claims.request.request',$data);
	}

	public function post_request()
	{
		$input = Input::all();

		$claimID = Claims_App::applyclaims($input);

        // $data['list'] = Claims_App::listClaims();
        $data['url'] = 'claims/request/requestDetail/'.$claimID;

        return json_encode($data);
	}

	public function get_requestDetail()
	{

		$data['claimID'] = $claimID = URI::segment(4);

		$data['app'] = $claimApp = Claims_App::appInfo($claimID);
		$data['detailList'] = Claims_App::listDetails($claimID);


		return View::make('claims.request.requestdetail',$data);
	}

	public function post_addDetail(){

		$input = Input::get();
		$claimID = $input['claimid'];
		$detailID = $input['detailId'];
        $input['detaildate'] = date('Y-m-d',strtotime($input['detaildate']));

        // echo "<pre>";print_r($input);die;
        unset($input['claimid']);
        unset($input['detailId']);

        if(!isset($detailID) || $detailID == NULL){
        	$claimDetails = Claims_App::find($claimID);
 			$claimDetails->detail()->insert($input);
        }else{
        	$claimDetails = Claims_Detail::find($detailID);
        	$claimDetails->fill($input);
        	$claimDetails->save();
        }
        

		return Claims_App::listDetails($claimID);

	}

	public function post_upload(){
		
		$input = Input::get();
		$file = Input::file('fileInput');

		$separator = ($input['claimdetailid'] != NULL )? $input['claimid'].'/'.$input['claimdetailid'] : $input['claimid'];

        $extension = File::extension($file['name']);
        $directory = 'upload/claims/'.sha1(Auth::user()->userid).'/'.str_replace("-", "", date('Y-m-d')).'/'.$separator; 
        $filename = Str::random(16, 'alpha').time().".{$extension}";

        if(!is_dir(path('public').$directory)){
            mkdir(path('public').$directory, 0777,true);
        }

        $maxSize = ini_get('upload_max_filesize')*1024*1024*1024;

        if($file['size'] != null && $file['size'] < $maxSize){
            try{
                $upload_success = Input::upload('fileInput', path('public').$directory, $filename);

                if($upload_success){

                    $input['recpath'] = $directory.'/'.$filename;

                    $receipt = new Claims_Receipt;
                    $receipt->fill($input);
                    $receipt->save();

                    Log::write('Claims Receipt', 'File Uploaded : ' . $filename.' by '.Auth::user()->username);

                    return $directory.'/'.$filename;
                }

            }catch (Exception $e) {
                Log::write('Claims Receipt', 'Upload error: ' . $e->getMessage());
            }
        }else{
            Log::write('Claims Receipt', 'Upload error: Exceed max size '.ini_get('upload_max_filesize'));
        }
	}

    public function post_deleteDetail(){
        
        $input = Input::get();

        Claims_Detail::find($input['id'])->delete();

        $files = Claims_Receipt::where('claimdetailid','=',$input['id'])->where('claimid','=',$input['claimid'])->get();

        foreach ($files as $record) {
        	$fileLoc = path('storage').$record->recpath;
        	if(file_exists ( $fileLoc )){ unlink($fileLoc); }

        }	

		Claims_Receipt::where('claimdetailid','=',$input['id'])->where('claimid','=',$input['claimid'])->delete();

        return Claims_App::listDetails($input['claimid']);
    }

    public function get_detailinfo(){

        $input = Input::get();

        $data = Claims_Detail::detailInfo($input['id']);

        return json_encode($data);
    }

    public function get_receipt(){

    	$input = Input::get();

    	$data = Claims_Receipt::receiptList($input['id']);

        return json_encode($data);
    }

    public function post_submitClaims(){

        $input = Input::get();

        /* code to update application status*/

        $url = 'claims/request/index';

        return $url;
    }


	public function get_approval()
	{
		return View::make('claims.request.approval');
	}

	public function get_history()
	{
		$data['claimlist'] = Claims_App::listClaims();

		return View::make('claims.request.history',$data);
	}
}

?>