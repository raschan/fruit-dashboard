<?php

class Connection extends Eloquent
{
    // MASS ASSIGNMENT -------------------------------------------------------
    protected $fillable = array('*');

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function user() {
        return $this->belongsTo('User');
    }
}

?>