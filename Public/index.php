<?php

/**
 * $APP_NAME 统一入口
 */

require_once dirname(__FILE__) . '/ZInit.php';


/** ---------------- 响应接口请求 ---------------- **/

// $api = new PhalApi();
$api = new MTS_ZPhalApi();#Brightness 2020-10-20 仿照 PhalApi 做出修改

$rs = $api->response();
$rs->output();

