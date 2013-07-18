<?php namespace Admin\Models\Monitor;
use \Laravel\Database\Eloquent\Model as Eloquent;

class Load extends Eloquent {

    public static $timestamps = true;
    public static $table = 'server_load';
    public static $key = 'load_id';


    public function cron($id,$data,$date){

        $exist = Load::where('server_id','=',$id)->first(array('load_id'));

        $load = (empty($exist))? new Load : Load::find($exist->load_id);

        $load->server_id = $id;
        $load->load_one = $data->one;
        $load->load_five = $data->five;
        $load->load_fifteen = $data->fifteen;
        $load->load_uptime = $data->uptime;
        $load->load_user = $data->user;
        $load->load_date = $date;
        $load->save();
    }

    public function stor($id,$data,$date,$table){

        static::$table = $table;

        $load = new Load ;

        $load->server_id = $id;
        $load->load_one = $data->one;
        $load->load_five = $data->five;
        $load->load_fifteen = $data->fifteen;
        $load->load_uptime = $data->uptime;
        $load->load_user = $data->user;
        $load->load_date = $date;
        $load->save();

    }

}