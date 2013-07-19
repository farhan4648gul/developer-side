<?php namespace Admin\Models\Modul;
use \Laravel\Database\Eloquent\Model as Eloquent,
    Admin\Libraries\Crapcrush as Crapcrush,
    Admin\Models\Navigation\Link as Link;

class Page extends Eloquent {

    public static $timestamps = true;
    public static $table = 'modul_pages';
    public static $key = 'modulpageid';

    public static function listpages(){
        
        $pagelist = Page::all();

        $arrayPages = array();

        foreach ($pagelist as $value) {

            if(isset($value->action) && $value->actionalias != '' && $value->visible == 1){
                $arrayPages[$value->modulpageid] = $value->actionalias;
            }
        }

        return $arrayPages;
    }

    public static function listAvailpages(){
        
        $pagelist = Page::all();

        $arrayPages = array();

        foreach ($pagelist as $value) {

            $regnav = Link::where('modulpageid','=',$value->modulpageid)->get();

            if(isset($value->action) && $value->actionalias != '' && $value->visible == 1 && empty($regnav)){
                $arrayPages[$value->modulpageid] = $value->actionalias;
            }
        }

        return $arrayPages;
    }

    public static function listSteppages($current = NULL){
        
        $pagelist = Page::all();

        $arrayPages['data'] = array('Sila Pilih');

        foreach ($pagelist as $value) {

            $regnav = Step::where('page','=',$value->modulpageid)->first() ;

            if(isset($value->action) && $value->actionalias != '' && $value->visible == 1 && (empty($regnav) OR ((!empty($regnav) && $current != NULL)? $regnav->stepid == $current:empty($regnav)))){
                $arrayPages['data'][$value->modulpageid] = $value->actionalias;
                if(!empty($regnav) && $regnav->stepid == $current) $arrayPages['selected'] = $regnav->page;
            }


        }

        return $arrayPages;
    }


    public static function getRegPages(){
        
        $strucModel = Page::order_by('modulpageid', 'asc')->get();//where('modul', '<>', 'admin')->

        $structModeling = array();

        foreach ($strucModel as $value) {

            if($value->action == NULL){

                $structModeling[$value->modul]['modulalias'] = $value->modulalias ;

                $structModeling[$value->modul][$value->controller] = array( 
                    'modulpageid' => $value->modulpageid ,
                    'controlleralias' => $value->controlleralias,
                    'visible' => $value->visible,
                    'header' => $value->header,
                    'footer' => $value->footer,
                    'auth' => $value->auth,
                    'admin' => $value->admin,
                    'arrangement' => $value->arrangement,

                );

            }else{

                $structModeling[$value->modul]['modulalias'] = $value->modulalias ;

                $structModeling[$value->modul][$value->controller][$value->action] = array( 
                    'modulpageid' => $value->modulpageid ,
                    'actionalias' => $value->actionalias,
                    'visible' => $value->visible,
                    'header' => $value->header,
                    'footer' => $value->footer,
                    'auth' => $value->auth,
                    'admin' => $value->admin,
                    'arrangement' => $value->arrangement,

                );
            }
        }

        return $structModeling;
    }

    public static function getdatapages(){

        $regVal = Page::getRegPages();
        $registered = array();

        foreach ($regVal as $modul => $contents) {
           unset($contents['modulalias']);

           $registered[$modul] = array();

           foreach ($contents as $submodul => $subcontent) {


               $registered[$modul][$submodul]= array();
               
               unset($subcontent['modulpageid']);
               unset($subcontent['controlleralias']);
               unset($subcontent['visible']);
               unset($subcontent['header']);
               unset($subcontent['footer']);
               unset($subcontent['auth']);
               unset($subcontent['admin']);
               unset($subcontent['arrangement']);

               foreach ($subcontent as $action => $actioncontent) {
                    
                    $registered[$modul][$submodul][$action] = array();

               }

           }
        }

        return $registered;

    }

    public static function setPages($component){
    			
    	$ctrlArrangment = count($component) + 1;

		foreach($component as $modul => $modulcontents){
        	unset($modulcontents['id']);
        	$ctrlArrangment = count($modulcontents) + 1;
        	foreach ($modulcontents as $submodul => $submodulcontents) {
				
				if($submodulcontents['id'] == null):
					$menu = new Page;
				else:
					$menu = Page::find($submodulcontents['id']);
				endif;

                if(isset($submodulcontents['remove']) && $submodulcontents['remove'] == 1){

                    Page::find($submodulcontents['id'])->delete();
                    unset($submodulcontents['remove']);

                }else{

                    $menu->modul = $modul;
                    $menu->controller = $submodul;
                    // $menu->controlleralias = $submodulcontents['controlleralias'];
                    $menu->visible = (isset($submodulcontents['show']) && $submodulcontents['show']=='on')?1:0;
                    $menu->auth = (isset($submodulcontents['auth']) && $submodulcontents['auth']=='on')?1:0;
                    $menu->admin = (isset($submodulcontents['admin'])&& $submodulcontents['admin']=='on')?1:0;
                    $menu->arrangement = isset($submodulcontents['arrangement'])?$submodulcontents['arrangement']:$ctrlArrangment;
                    $menu->save();


                    unset($submodulcontents['arrangement']);
                    unset($submodulcontents['controlleralias']);
                    unset($submodulcontents['show']);
                    unset($submodulcontents['auth']);
                    unset($submodulcontents['admin']);
                }

        		unset($submodulcontents['id']);

                $actionArrangment = count($submodulcontents) + 1;

        		foreach ($submodulcontents as $action => $actioncontents) {


                    if($actioncontents['id'] == null):
                        $menu = new Page;
                    else:
                        $menu = Page::find($actioncontents['id']);
                    endif;

                    if(isset($actioncontents['remove']) && $actioncontents['remove'] == 1){

                        Page::find($actioncontents['id'])->delete();

                    }else{
                        
                        $menu->modul = $modul;
                        $menu->controller = $submodul;
                        $menu->action = $action;
                        $menu->actionalias = $actioncontents['actionalias'];
                        $menu->visible = (isset($actioncontents['show']) && $actioncontents['show']=='on')?1:0;
                        $menu->auth = (isset($actioncontents['auth']) && $actioncontents['auth']=='on')?1:0;
                        $menu->admin = (isset($actioncontents['admin']) && $actioncontents['admin']=='on')?1:0;
                        $menu->arrangement = isset($actioncontents['arrangement'])?$actioncontents['arrangement']:$actionArrangment;
                        $menu->save();
                    }

                    unset($submodulcontents[$action]);

                    $actionArrangment++;
        		}

        		$ctrlArrangment++;
        	}

		}

    } 



    public static function composer(){

        $arc = new Crapcrush;
        // $structures = $arc->getadmin();
        $structures = Crapcrush::getstructures();

        $ctrArr = 1;
        foreach($structures as $modul => $content){
            
            foreach ($content as $submodul => $subcontent) {

                $submodulExisted = Page::where('controller','=',$submodul)->get();

                if(!$submodulExisted){
                    $modulModel = new Page;
                    $modulModel->modul = $modul;
                    $modulModel->controller = $submodul;
                    $modulModel->visible = 1;
                    $modulModel->auth = 1;
                    $modulModel->arrangement = $ctrArr;
                    $modulModel->header = 1;
                    $modulModel->save();
                }

                $actArr = 1;
                foreach ($subcontent as $action) {

                    $actionExisted = Page::where('controller','=',$submodul)->where('action','=',$action)->get();

                    if(!$actionExisted){
                        $modulModel = new Page;
                        $modulModel->modul = $modul;
                        $modulModel->controller = $submodul;
                        $modulModel->action = $action;
                        $modulModel->visible = 1;
                        $modulModel->auth = 1;
                        $modulModel->arrangement = $actArr;
                        $modulModel->header = 1;
                        $modulModel->save();
                    }

                    $actArr++;

                }

                $ctrArr++;
            }

        }
        
    }

}