<?php

namespace Cloudmanic\DayLife;

class DefaultEncodingHook 
{
	public function encode($k, $v, $ret) {
		array_push($ret, urlencode($k).'='.urlencode($v));
		return $ret;
	}
}

/* End File */