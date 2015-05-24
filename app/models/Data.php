<?php

class Data extends Eloquent
{
    // MASS ASSIGNMENT -------------------------------------------------------
    protected $fillable = array('*');

	// LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of data is not what we named our database table we have to define it
    protected $table = 'data';

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function widget() {
        return $this->belongsTo('Widget');
    }
}

?>