<?php

namespace Abf;

use Eloquent;

class Event extends Eloquent
{
	protected $fillable = array('*');

	protected $guarded = array('user','id');
}

?>