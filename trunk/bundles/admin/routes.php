<?php

Route::controller(Controller::detect('admin'));

Route::filter('auth', function(){
	if (Auth::guest()) return Redirect::to(URL::to_action('admin::login'));
});