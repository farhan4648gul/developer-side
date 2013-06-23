<?php

class Claims_Detail extends Eloquent
{
	public static $timestamps = true;
	public static $table = 'claims_details';
	public static $key = 'claimdetailid';



	public function claims()
  	{
        return $this->belongs_to('Claims_App');
  	}

    public function receipt()
    {
      return $this->has_many('Claims_Receipt','claimdetailid');
    }

  	public static function detailInfo($claimdetailid){

  		$detail = Claims_Detail::find($claimdetailid);

  		$data['claimid'] = $detail->claimid ;
  		$data['detaildate'] = date('d/m/Y',strtotime($detail->detaildate)); ;
  		$data['detaildesc'] = $detail->detaildesc ;
  		$data['detailfrom'] = $detail->detailfrom ;
  		$data['detailto'] = $detail->detailto ;
  		$data['detailmile'] = $detail->detailmile ;
  		$data['detailtoll'] = $detail->detailtoll ;
  		$data['detailpark'] = $detail->detailpark ;

  		return $data;


  	}


}