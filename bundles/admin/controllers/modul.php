<?php

use Admin\Models\Modul\Flow as Flow,
    Admin\Models\Modul\Step as Step,
    Admin\Models\Modul\Page as Page,
    Admin\Models\User\Role as Role,
    Laravel\Str as Str,
    Laravel\Log as Log,
    Laravel\URI as URI,
    Laravel\Input as Input,
    Admin\Libraries\Menu as Menu,
    Admin\Libraries\Crapcrush as Crapcrush;

/**
 * Admin Modul class
 *
 * @package default
 * @author joharijumali@gmail.com
 **/

class Admin_Modul_Controller extends Admin_Base_Controller {

	public $restful = true;

    public function get_index(){

    	return View::make('admin::modul.index');

    }

    /**
     * Modul Managment function
     * Component : register
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/
    

    public function get_register(){

    	return View::make('admin::modul.index');

    }


    public function post_recomp(){

        Page::composer();

        Log::write('Module', 'Registering Modul & Page by '.Auth::user()->username);

    }

    /**
     * Page Managment function
     * Component : page
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/
    

    public function get_page(){

        $data['struct'] = Menu::page();

    	return View::make('admin::modul.page',$data);

    }

    public function post_page(){
        $contents = Input::all();

        Page::setPages($contents);

        return Redirect::to('admin/modul/page');

        Log::write('Module', 'Modify Page Information by '.Auth::user()->username);
    }

    /**
     * Flow Managment function
     * Component : flow, flowinfo
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/

    public function get_flow(){

        $data['flowlist'] = Flow::listFlow();
        return View::make('admin::modul.flow',$data);

    }

    public function post_flow(){

        $input = Input::get();

        if($input['flowid'] == NULL):
            $logs = 'Add New Flow ';
            $flow = new Flow;
        else:
            $flow = Flow::find($input['flowid']);
            $logs = 'Edit Flow ';
        endif;
        $flow->flowname  = Str::title($input['flowname']);
        $flow->timestamp();
        $flow->save();

        Log::write('Modul', $logs.$input['flowname'].' by '.Auth::user()->username);

        return Flow::listFlow();

    }

    public function get_flowinfo(){
        $input = Input::get();

        $flow = Flow::find($input['flowid']);
        
        $data['flowname'] = $flow->flowname;
        $data['flowid'] = $flow->flowid;

        return json_encode($data);
    }


    /**
     * Flow Step Managment function
     * Component : step, stepinfo, resetstepdata,  deletestep
     * Method : ajax post get
     * @return void
     * @author joharijumali@gmail.com
     **/

    public function get_step(){

        $data['flow'] =  Str::title(Flow::find(URI::segment(4))->flowname);
        $data['steplist'] = Menu::flowtree(URI::segment(4));
        $data['allrole'] = Role::arrayRoles();
        //$allstep = Step::steploop(URI::segment(4));

        return View::make('admin::modul.step',$data);

    }

    public function post_step(){

        $input = Input::get();

        if($input['stepid'] == NULL):
            $logs = 'Add New Step ';
            $step = new Step;
        else:
            $step = Step::find($input['stepid']);
            $step->roleid  = $input['roleid'];
            $step->next  = $input['next'];
            $step->condition1  = $input['condition1'];
            $step->condition2  = $input['condition2'];
            $logs = 'Edit Step ';
        endif;

        $step->step  = Str::title($input['step']);
        $step->flowid  = $input['flowid'];
        $step->parentid  = $input['parentid'];
        $step->roleid  = $input['roleid'];
        $step->timestamp();
        $step->save();

        Log::write('Modul', $logs.$input['step'].' by '.Auth::user()->username);

        return Menu::flowtree($input['flowid']);

    }

    public function get_stepinfo(){
        $input = Input::get();

        $step = Step::find($input['stepid']);
        
        $data['step'] = $step->step;
        $data['stepid'] = $step->stepid;
        $data['flowid'] = $step->flowid;
        $data['parentid'] = $step->parentid;

        return json_encode($data);
    }

    public function get_resetstepdata(){

        $data['next'] = $data['condition1'] = $data['condition2'] = $list = Step::arraySteps();

        return json_encode($data);

    }

    public function post_deletestep(){
        $input = Input::get();

        Log::write('User', 'Delete Step ID '.Step::find($input['id'])->step.' by '.Auth::user()->username);

        Step::find($input['id'])->delete();
        Step::where('parentid','=',$input['id'])->delete();

        return Menu::flowtree($input['flowid']);
    }

}