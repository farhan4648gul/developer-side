<?php 

/*********************************************************************
*  Class : Flow
*  Function : 
*  Author :  joharijumali
*  Description: Class for Getting Application Flow
**********************************************************************/

class Flow{

    /**
     * sidebar function
     * Create sidebar
     * @return string
     * @author joharijumali
     **/

    public static function next() {

    	$path = URI::segment(2).'/'.URI::segment(3).'/'.URI::segment(4);

    	$page = Console_Page::where('modul','=',URI::segment(2))->where('controller','=',URI::segment(3))->where('action','=',URI::segment(4))->first();

    	if($page){
    		try{
	    		$currentStep = Console_Step::where('page','=',$page->modulpageid)->first();
	    		if(!empty($currentStep)){

	    			if($currentStep->parentid == 0)
	    				return $currentStep->stepid;
	    			else{
	    				$nextStep = Console_Step::where('flowid','=',$currentStep->flowid)->where('parentid','=',$currentStep->stepid)->first();
	    				if($nextStep) return $nextStep->stepid;
	    			}
	    		}
    		}catch (Exception $e) {
    			Log::write('Flow', 'Status Retrieving Failed: ' . $e->getMessage());
    		}
    	}else{
    		Log::write('Flow', 'Page Not Exist: ');
    	}

    }



 }
 ?>