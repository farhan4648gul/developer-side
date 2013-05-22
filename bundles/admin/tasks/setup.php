<?php
    
use Laravel\CLI\Command as Command;
use Admin\Models\Admin as Admin;

class Admin_Setup_Task {

    public function run($arguments){


        $data = array(
            'name' => 'System Administrator',
            'username' => $arguments[0],
            'password' => Hash::make($arguments[1])
        );

        $user = Admin::create($data);

        echo ($user) ? 'Admin created successfully!' : 'Error creating admin!';

    }

}