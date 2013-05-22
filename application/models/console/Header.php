<?php



class Console_Header extends Eloquent
{
	public static $timestamps = true;
	public static $table = 'navigation_headers';
	public static $key = 'navheaderid';
	
	public function navpages()
	{
		return $this->has_many('Console_Link', 'navheaderid');
	}

	public static function navigationdata(){

		$testlist = array();
		$returndata = array();
		$navheader = Console_Header::order_by('step', 'asc')->get();

		foreach ($navheader as $key => $value) {

			$returndata[$key]['header'] = $value->navheader;
			$returndata[$key]['moduleid'] = $value->navheaderid;
			$testlist = Console_Header::find($value->navheaderid)->navpages()->order_by('parentstep', 'asc')->get();

				foreach ($testlist as $ckey => $cvalue) {
					
					$parent = Console_Page::find($cvalue->modulpageid);

					if (!empty($parent) && $cvalue->parentid == NULL) {
							
						$returndata[$key]['parent'][$ckey]['alias']= $parent->actionalias;
						$returndata[$key]['parent'][$ckey]['pageid']= $cvalue->navpageid;
						$returndata[$key]['parent'][$ckey]['path']= $parent->modul.'/'.$parent->controller.'/'.$parent->action;

						$child = Console_Link::where('parentid', '=', $cvalue->navpageid)->get();

						if(!empty($child)){

							foreach ($child as $childkey => $childvalue) {
								$childpage = Console_Page::find($childvalue->modulpageid);

								$returndata[$key]['parent'][$ckey]['child'][$childkey]['alias']= $childpage->actionalias;
								$returndata[$key]['parent'][$ckey]['child'][$childkey]['childid']= $childvalue->navpageid;
								$returndata[$key]['parent'][$ckey]['child'][$childkey]['path']= $childpage->controller.'/'.$childpage->action;
							}
							
						}

					}

				}

		}

		return $returndata;

	}

}