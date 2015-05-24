<?php

class Data extends Eloquent
{
    // MASS ASSIGNMENT -------------------------------------------------------
    protected $fillable = array('*');

	// LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of fish isnt what we named our database table we have to define it
    protected $table = 'Data';

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function widget() {
        return $this->belongsTo('Widget');
    }
}

?>