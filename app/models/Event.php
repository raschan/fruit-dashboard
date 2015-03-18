<?php

namespace Abf;		// needed because of conflicts with Laravel and Stripe

use Eloquent;

class Event extends Eloquent
{
	protected $fillable = array('*');

	protected $guarded = array('user','id');
}

?>