<?php

class Data_Claims_Cat extends Eloquent
{

	public static $timestamps = true;
    public static $table = 'data_claims_cat';
    public static $key = 'claimcatid';

    public static function arrayCats()
    {
        $catlist = Data_Claims_Cat::all();

        $arrayCats = array();
        $arrayCats[0] = 'Choose Category';
        foreach ($catlist as $value) {
            $arrayCats[$value->claimcatid] = $value->claims_cat_name;
        }

        return $arrayCats;
    }

    public function app()
    {
        return $this->belongsToMany('Claims_App','claimcatid');
    }

}