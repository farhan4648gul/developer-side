<?php

class Claims_Receipt extends Eloquent
{
	public static $timestamps = true;
	public static $table = 'claims_receipts';
	public static $key = 'claimrecid';



  public function claims()
  {
    return $this->belongs_to('Claims_App');
  }

	public function details()
  {
    return $this->belongs_to('Claims_Detail');
	}

  public static function saveReceipt($data){

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

  public static function receiptList($claimdetailid){

    $receiptList = Claims_Receipt::where('claimdetailid','=',$claimdetailid)->get();

    $arrayList = array();

    foreach ($receiptList as $obj) {
      array_push($arrayList, $obj->recpath);
    }

    return $arrayList;

  }


}