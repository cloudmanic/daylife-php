<?php

namespace Cloudmanic\DayLife;

class JsonDatasource 
{
    var $json_datasource_url = null;
    var $encoding_hook = null;

    public function __construct($json_datasource_url, $encoding_hook=null) {
        $this->json_datasource_url = $json_datasource_url;
        if (!$encoding_hook) {
        	$encoding_hook = new DefaultEncodingHook();
        }
        $this->encoding_hook = $encoding_hook;
    }


    /**
     * Magic method to invoke an json server method.
     */
    public function __call($call, $args=array()) {
    	if(count($args) != 0) {
    		$args=$args[0];
    	}
		$url = $this->json_datasource_url . $call;
		$post_field = html_entity_decode($this->query_string_encode($args,null));
		$file = $this->constructUrl($call, $args);
		$json = file_get_contents($file);

		return json_decode($json, true);
    }
    
	public function constructUrl($action, $params) {
		$url = $this->json_datasource_url . $action;
		$query = html_entity_decode($this->query_string_encode($params,null));
		//print($url . '?' . $query . "\n");
		return $url . '?' . $query;
	}
	
	public function query_string_encode($data, $key) {
		$ret = array();
		foreach ((array)$data as $k => $v) {
			if(!empty($key)) {
				$k = $key;
      			}
			if (is_array($v) || is_object($v)) {
				//array_push($ret, $this->query_string_encode($v,$k));
				$ret = $this->encoding_hook->encode_array($k, $v, $ret);
			} else if (isset($v)) {
    				$ret = $this->encoding_hook->encode($k, $v, $ret);
	    		}
		}	
		$sep = ini_get('arg_separator.output');
		return implode($sep, $ret);
	}

    private function get_microsecs() {
		$time = gettimeofday(true);
		$seconds = $time['sec'];
		$micros = $time['usec'];
		return $seconds . "." . $micros;
    }
}

/* End File */