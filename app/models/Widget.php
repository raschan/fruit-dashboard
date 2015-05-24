<?php

class Widget extends Eloquent
{
    // MASS ASSIGNMENT -------------------------------------------------------
    protected $fillable = array('*');

    // DEFINE RELATIONSHIPS --------------------------------------------------

    // each widget has lots of data
    public function data() {
        return $this->hasMany('Data');
    }

    // each widget has one connection
    public function connection() {
        return $this->hasOne('Connection');
    }

}

?>