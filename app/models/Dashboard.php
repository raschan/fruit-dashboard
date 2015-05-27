<?php

class Dashboard extends Eloquent
{

    // MASS ASSIGNMENT -------------------------------------------------------
    protected $fillable = array('*');

    // DEFINE RELATIONSHIPS --------------------------------------------------

    // each dashboard has many widgets    
    public function widgets() {
        return $this->hasMany('Widget');
    }

    // each dashboard can belong to many users
    public function users() {
        return $this->belongsToMany('User', 'users_dashboards', 'dashboard_id', 'user_id');
    }

}

?>
