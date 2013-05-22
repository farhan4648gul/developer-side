<?php namespace Admin\Models\Navigation;
use \Laravel\Database\Eloquent\Model as Eloquent;
class Link extends Eloquent {

    public static $timestamps = true;
    public static $table = 'navigation_pages';
    public static $key = 'navpageid';

    public function modulpage()
    {
        return $this->has_one('Admin\Models\Modul\Page','modulpageid');
    }

}