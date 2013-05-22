<?php

use Admin\Models\Modul\Step as Step,
    Admin\Models\Modul\Page as Page,
    Admin\Models\User\Role as Role,
    Admin\Models\Navigation\Header as Header,
    Admin\Models\Navigation\Link as Link,
    Admin\Libraries\Menu as Menu,
    Logger as Logger;

/**
 * System Data Management Modul class
 *
 * @package default
 * @author joharijumali@gmail.com
 **/

class Admin_Data_Controller extends Admin_Base_Controller {


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function get_board()
	{

		return View::make('admin::data.board');
	}

}// END class 