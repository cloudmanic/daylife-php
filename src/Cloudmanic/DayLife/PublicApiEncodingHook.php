<?php

namespace Cloudmanic\DayLife;

class PublicApiEncodingHook 
{
    var $access_key = null;
    var $shared_secret = null;
    var $id_params = array("topic_id", "quote_id", "image_id", "article_id", "source_id");
    var $name_params = array("query", "name", "url", "content");

    public function __construct($access_key, $shared_secret) {
        $this->access_key = $access_key;
        $this->shared_secret = $shared_secret;
    }

    public function encode($k, $v, $ret) {
        $is_id = false;
        $is_name = false;
        if ($is_id = in_array($k, $this->id_params) || $is_name = in_array($k, $this->name_params)) {
            #if ($is_id && is_numeric($v)) {
            #    $v = encode_id($v);
            #}
            $signature = md5($this->access_key . $this->shared_secret . $v);
            array_push($ret, urlencode("signature").'='.urlencode($signature));
            array_push($ret, urlencode("accesskey").'='.urlencode($this->access_key));
        }
        array_push($ret, urlencode($k).'='.urlencode($v));
	return $ret;
    }

	public function encode_array($k, $v, $ret) {
		$is_id = false;
		$is_name = false;
		if ($is_id=in_array($k,$this->id_params) || $is_name=in_array($k,$this->name_params)) {
			sort($v);
			$signature = md5($this->access_key . $this->shared_secret . implode("",$v));
		        array_push($ret, urlencode("signature").'='.urlencode($signature));
            		array_push($ret, urlencode("accesskey").'='.urlencode($this->access_key));
		}
		foreach($v as $x) {
			array_push($ret, urlencode($k).'='.urlencode($x));
		}
		return $ret;
	}
}

/* End File */