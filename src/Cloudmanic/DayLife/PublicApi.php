<?php

namespace Cloudmanic\DayLife;

class PublicApi extends JsonDatasource 
{
    public function __construct($json_datasource_url, $access_key, $shared_secret) 
    {
        parent::__construct($json_datasource_url, new PublicApiEncodingHook($access_key, $shared_secret));
    }
}

/* End File */
