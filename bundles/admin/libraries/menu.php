<?php namespace Admin\Libraries;

use Bootstrapper\Navigation as Navigation,
    Laravel\Str as Str,
    Laravel\URI as URI,
    Bootstrapper\Form as Form,
    Admin\Models\Navigation\Header as Header,
    Admin\Models\Modul\Step as Step,
    Admin\Models\Modul\Page as Page;

/*********************************************************************
*  Class : Menu
*  Function : Menu Class
*  Author :  joharijumali
*  Description: Class for to create Navigation
**********************************************************************/

class Menu extends Crapcrush{

	public static function page(){

   		$arc = new Crapcrush;
   		$totalStruct = $arc->getstructures();

   		$structModeling = Page::getRegPages();

   		$view = '<ul class="nav nav-list">';
   		
   		foreach ($totalStruct as $modul => $content) {
   			
   			if(!empty($structModeling[$modul])){
   			$view .= '<li class="nav-header alert alert-info"><i class="icon-hdd"></i>&nbsp;'.Str::upper($modul).'</li>';
   			$view .=  Form::hidden($modul.'[id]');
   			$registered = !empty($structModeling[$modul])? 'alert alert-success':'alert';
   			$view .=  '<li class="'.$registered.'">';
   			$idiv = count( $content);

   			foreach($content as $submodul => $subcontent){
   				if(isset($structModeling[$modul][$submodul])){
   				$view .=  '<ul class="nav nav-list">';
   				$view .=  '<li style="height:30px" ><i class="icon-folder-close"></i>&nbsp;'.Str::title($submodul);
   				$submodulID = isset($structModeling[$modul][$submodul])?$structModeling[$modul][$submodul]['modulpageid']:null;
   				$view .=  Form::hidden($modul.'['.$submodul.'][id]',$submodulID);
	   			$view .= '</li>';

	   			$arrayBal = array();
   				$view .=  '<li ><ul class="nav nav-list">';
   				foreach($subcontent as $action){
   					$registered = !isset($structModeling[$modul][$submodul][$action])? 'class ="alert" style="border:none;background-color:transparent;padding:0px;height:30px;margin-bottom:0px;" ':'style="height:30px" ';
   					$view .=  '<li '.$registered.'>';
   					$view .= '<i class="icon-list-alt "></i>&nbsp;'.Str::title($action).'&nbsp;<em><small>'.Str::title($modul.'/'.$submodul.'/'.$action).'</small></em>';
   					$actionID = isset($structModeling[$modul][$submodul][$action])?$structModeling[$modul][$submodul][$action]['modulpageid']:null;
   					$view .=  Form::hidden($modul.'['.$submodul.']['.$action.'][id]',$actionID);
		   			
		   			$view .= '<div class="span6 form-inline pull-right" >';
		   			$actionArrg = isset($structModeling[$modul][$submodul][$action])?$structModeling[$modul][$submodul][$action]['arrangement']:null;
   					$view .= Form::mini_text($modul.'['.$submodul.']['.$action.'][arrangement]', $actionArrg , array('class' => 'input-small','style'=>'height:10px;width:10px','placeholder' => '#'));
					$actionAlias = isset($structModeling[$modul][$submodul][$action])? $structModeling[$modul][$submodul][$action]['actionalias']:'';
					$view .= Form::mini_text($modul.'['.$submodul.']['.$action.'][actionalias]', $actionAlias , array('class' => 'input-small','style'=>'height:10px;font-size:12px;','placeholder' => 'Alias'));
					$view .= '&nbsp;';
					$actionVisible = isset($structModeling[$modul][$submodul][$action])? $structModeling[$modul][$submodul][$action]['visible']:0;
					$actionVisibleChecked = ($actionVisible == 1)? array('checked') : array();
					$view .= Form::labelled_checkbox($modul.'['.$submodul.']['.$action.'][show]', '<em><small>Show</small></em>',null,$actionVisibleChecked);
					$view .= '&nbsp;';
					$actionAuth = isset($structModeling[$modul][$submodul][$action])? $structModeling[$modul][$submodul][$action]['auth']:0;
					$actionAuthChecked = ($actionAuth == 1)? array('checked') : array();
					$view .= Form::labelled_checkbox($modul.'['.$submodul.']['.$action.'][auth]', '<em><small>Auth</small></em>',null,$actionAuthChecked);
					$view .= '&nbsp;';
					$actionAdmin = isset($structModeling[$modul][$submodul][$action])? $structModeling[$modul][$submodul][$action]['admin']:0;
					$actionAdminChecked = ($actionAdmin == 1)? array('checked') : array();	
					$view .= Form::labelled_checkbox($modul.'['.$submodul.']['.$action.'][admin]', '<em><small>Admin Only</small></em>',null,$actionAdminChecked);
					$view .= '&nbsp;';
		   			$view .= '</div>';
		   			$view .= '</li>';

		   			unset($structModeling[$modul][$submodul][$action]);

   				}
   				$view .=  '</ul></li>';
   				$idiv --;

   				if($idiv!=0){
   					$view .= '<li class="divider"></li>';
   				}

        		unset($structModeling[$modul][$submodul]['modulpageid']);
        		unset($structModeling[$modul][$submodul]['arrangement']);
        		unset($structModeling[$modul][$submodul]['controlleralias']);
        		unset($structModeling[$modul][$submodul]['visible']);
        		unset($structModeling[$modul][$submodul]['auth']);
        		unset($structModeling[$modul][$submodul]['admin']);
        		unset($structModeling[$modul][$submodul]['header']);
        		unset($structModeling[$modul][$submodul]['footer']);

	   			if(!empty($structModeling[$modul][$submodul])){
	   				
	   				$view .=  '<li class="alert-error">';
	   				foreach ($structModeling[$modul][$submodul] as $deletedaction => $deletedcontent) {
		   				
				    	$view .=  '<ul class="nav nav-list">';
				    	$view .=  '<li>';
		  				$view .=  '<i class="icon-remove"></i>&nbsp;'.Str::title($deletedcontent['actionalias']).'&nbsp;<em>'.$modul.'/'.$submodul.'/'.$deletedaction.'</em>';
		  				$view .=  Form::hidden($modul.'['.$submodul.']['.$deletedaction.'][id]',$deletedcontent['modulpageid']);
		  				$view .= '<div class="span6 form-inline pull-right" >';
			            $view .= Form::labelled_checkbox($modul.'['.$submodul.']['.$deletedaction.'][remove]', '<em><small>Remove</small></em>');
		   				$view .= '</div>';
		  				$view .= '</li>';
				    	$view .=  '</ul >';

				    	unset($structModeling[$modul][$submodul][$deletedaction]);
	   				}
		   			$view .= '</li>';

	   			}

   				$view .= '</ul>';
   				if(empty($structModeling[$modul][$submodul])){
					unset($structModeling[$modul][$submodul]);
					unset($structModeling[$modul]['modulalias']);
   				}
   				}

   			}

   			$view .= '</li>';
   			if(empty($structModeling[$modul])){
   				unset($structModeling[$modul]);
   			}

   			}
   		}


   		if(!empty($structModeling)){
	   		$view .=  '<li class="divider"></li>';
   			foreach ($structModeling as $modulDeleted => $contentDeleted) {
   				$view .= '<li class="nav-header alert alert-error"><i class="icon-hdd"></i>&nbsp;'.Str::upper($modulDeleted).'</li>';
   				unset($contentDeleted['modulalias']);
   				$view .=  '<li class="alert alert-error">';
   				$view .=  '<ul class="nav nav-list">';
   				foreach ($contentDeleted as $submodulDeleted => $subcontentDeleted) {

		    	$view .= '<li  style="height:30px;">';
  				$view .= '<i class="icon-remove"></i>&nbsp;'.Str::title($subcontentDeleted['controlleralias']).'&nbsp;<em>'.$modulDeleted.'/'.$submodulDeleted.'</em>';
  				$view .=  Form::hidden($modulDeleted.'['.$submodulDeleted.'][id]',$subcontentDeleted['modulpageid']);
  				$view .= '<div class="span6 form-inline pull-right" >';
	            $view .= Form::labelled_checkbox($modulDeleted.'['.$submodulDeleted.'][remove]', '<em><small>Remove</small></em>');
   				$view .= '</div>';
  				$view .= '</li>';

   				unset($subcontentDeleted['controlleralias']);
   				unset($subcontentDeleted['visible']);
   				unset($subcontentDeleted['auth']);
   				unset($subcontentDeleted['admin']);
   				unset($subcontentDeleted['header']);
   				unset($subcontentDeleted['footer']);
   				unset($subcontentDeleted['arrangement']);
   				unset($subcontentDeleted['modulpageid']);

					$view .=  '<li >';
					$view .=  '<ul class="nav nav-list">';
	   				foreach ($subcontentDeleted as $deletedaction => $deletedcontent) {
		   				

				    	$view .= '<li style="height:30px;">';
		  				$view .= '<i class="icon-remove"></i>&nbsp;'.Str::title($deletedcontent['actionalias']).'&nbsp;<em>'.$modulDeleted.'/'.$submodulDeleted.'/'.$deletedaction.'</em>';
		  				$view .=  Form::hidden($modulDeleted.'['.$submodulDeleted.']['.$deletedaction.'][id]',$deletedcontent['modulpageid']);
		  				$view .= '<div class="span6 form-inline pull-right" >';
			            $view .= Form::labelled_checkbox($modulDeleted.'['.$submodulDeleted.']['.$deletedaction.'][remove]', '<em><small>Remove</small></em>');
		   				$view .= '</div>';
		  				$view .= '</li>';

				    	unset($structModeling[$modulDeleted][$submodulDeleted][$deletedaction]);
	   				}
				    $view .=  '</ul >';
		   			$view .= '</li>';


   				}
   				$view .= '</ul>';
   				$view .= '</li>';
   			}


   		}

   		$view .= '</ul>';
   		return $view;


	}

  public static function navTree(){

    $data = Header::navigationdata();

    $view = '';

    foreach ($data as $key => $content) {
      $view .= '<li ><ul class="nav nav-list">';
      $view .= '<li class="nav-header" style="height:30px"><i class="icon-hdd"></i>&nbsp;'.Str::upper($content['header']);
      $view .= '<div class="form-inline pull-right" >';
      $view .= '<a href="#" onclick="deleteModule('.$content['moduleid'].')" style="margin-bottom:10px;margin-left:5px;"><i class="icon-remove alert-error"></i></a>';//<em><small>Remove Module</small></em>
      $view .= '</div>';
      $view .= Form::hidden('module[]',$content['moduleid']);
      $view .= '</li>';
      if(!empty($content['parent']) || isset($content['parent'])){
        $view .=  '<li ><ul id="sortparent" class="nav nav-list connectedparent" style="padding-right:0px">';

        foreach ($content['parent'] as $parentkey => $parentcontent) {
          $view .=  '<li style="height:30px" ><i class="icon-arrow-right"></i>&nbsp;'.Str::title($parentcontent['alias']);
          $view .= '<div class="form-inline pull-right">';
          $view .=  '<a href="#" onclick="addchildpages('.$parentcontent['pageid'].')" data-toggle="modal" style="margin-bottom:10px;margin-left:5px;"><i class="icon-plus"></i></a>';//<em><small>Add Sub Page</small></em>
          $view .=  '<a href="#" onclick="deletePage('.$parentcontent['pageid'].')" style="margin-bottom:10px;margin-left:5px;"><i class="icon-remove alert-error"></i></a>';//<em><small>Remove Page</small></em>
            $view .= '</div>';
            $view .= Form::hidden('parent[]',$parentcontent['pageid']);
            $view .= '</li>';

            if(!empty($parentcontent['child'])){
              $view .=  '<li ><ul id="sortchild" class="nav nav-list connectedchild" style="padding-right:0px">';

              foreach ($parentcontent['child'] as $childkey => $childvalue) {

                $view .= '<li style="height:30px" ><i class="icon-arrow-right"></i>&nbsp;'.Str::title($childvalue['alias']);
              $view .= '<div class="form-inline pull-right">';
              $view .= '<a href="#" onclick="deletePage('.$childvalue['childid'].')" style="margin-bottom:10px;margin-left:5px;"><i class="icon-remove alert-error"></i></a>';//<em><small>Remove Sub Page</small></em>
                $view .= '</div>';
                $view .= '</li>';

              }
              
              $view .=  '</ul></li>';
            }

        }

          $view .=  '</ul></li>';
      }
      $view .=  '</ul></li>';
      
    }

    return $view;

  }

  public static function flowtree($flowid){

    $structure = '';
    $data = Step::steploop($flowid);

    if(!empty($data)){
      $structure .= '<ul class="nav nav-list">';
      foreach ($data as $key => $value) {
        $structure .= '<li>';
        $structure .= '<a href="#" onclick="deleteStep('.$key.')" style="float:right">&nbsp;<i class="icon-remove-sign"></i></a>';
        $structure .= '<a href="#" onclick="editStep('.$key.')" style="float:right">&nbsp;<i class="icon-edit"></i></a>';
        $structure .= '<a href="#" onclick="addStep('.$key.')" ><i class="icon-bookmark"></i>&nbsp;'.Str::title($value['desc']).'&nbsp;<i class="icon-plus-sign"></i></a>';
        $structure .= self::looper($value['child']); 
        $structure .= '</li>';
      }
      $structure .=  '</ul>';

    }else{
      $structure = '<a href="#addDataModal" data-toggle="modal" >Add Steps&nbsp;<i class="icon-plus"></i></a>';
    }

    return $structure;

  }

  protected static function looper($child){

      $structure = '';
      if(!empty($child)){
        $structure .= '<ul class="nav nav-list" style="margin-left:60px;padding-left:0px;padding-right:0px;border-left-width:3px;border-left-style:solid;border-left-color:#000">';
        foreach ($child as $key => $value) {
          $structure .= '<li>';
          $structure .= '<a href="#" onclick="deleteStep('.$key.')"  data-toggle="tooltip" data-title="remove step" style="float:right">&nbsp;<i class="icon-remove-sign"></i></a>';
          $structure .= '<a href="#" onclick="editStep('.$key.')" style="float:right">&nbsp;<i class="icon-edit"></i></a>';
          $structure .= '<a href="#" onclick="addStep('.$key.')" data-toggle="modal" ><i class="icon-arrow-right"></i>&nbsp;'.Str::title($value['desc']).'&nbsp;<i class="icon-plus-sign"></i></a>';
          $structure .= self::looper($value['child']);
          $structure .= '</li>';
        }
        $structure .=  '</ul>';
      }

      return $structure;

  }

}
?>