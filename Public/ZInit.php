<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-29 15:07:55
 * @LastEditors: Brightness
 * @LastEditTime: 2021-01-25 09:58:50
 * @Description: 初始化文件
 */

/**
 * 统一初始化
 */
 
/** ---------------- 根目录定义，自动加载 ---------------- **/

date_default_timezone_set('Asia/Shanghai');

defined('API_ROOT') || define('API_ROOT', dirname(__FILE__) . '/..');

// require_once API_ROOT . '/PhalApi/PhalApi.php';
require_once API_ROOT . '/Library/MTS/ZPhalApi.php';#Brightness 2020-10-20
require_once API_ROOT . '/Library/MTS/GlobalVar.php';#Brightness 2021-01-25


$loader = new PhalApi_Loader(API_ROOT, 'Library');

if (file_exists(API_ROOT . '/vendor/autoload.php')) {
    require_once API_ROOT . '/vendor/autoload.php';
}

/** ---------------- 注册&初始化 基本服务组件 ---------------- **/

$di = DI();

// 自动加载
$di->loader = $loader;

//装载你的接口
$di->loader->addDirs(array('Brightness', 'Library'));

// 配置
$di->config = new PhalApi_Config_File(API_ROOT . '/Config');

// 调试模式，$_GET['__debug__']可自行改名
$di->debug = !empty($_GET['__debug__']) ? true : $di->config->get('sys.debug');

if ($di->debug) {
    // 启动追踪器
    $di->tracer->mark();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On'); 
}

// 日记纪录
$di->logger = new PhalApi_Logger_File(API_ROOT . '/Runtime', PhalApi_Logger::LOG_LEVEL_DEBUG | PhalApi_Logger::LOG_LEVEL_INFO | PhalApi_Logger::LOG_LEVEL_ERROR);

// 数据操作 - 基于NotORM
$di->notorm = function () {
    return new PhalApi_DB_NotORM(DI()->config->get('dbs'), DI()->debug);
};

//读写分离
// $di->readNotorm = function () {
//     return new PhalApi_DB_NotORM(DI()->config->get('dbs'), DI()->debug);
// };

// $di->writeNotorm = function () {
//     return new PhalApi_DB_NotORM(DI()->config->get('dbs'), DI()->debug);
// };

//注册返回数据格式
$di->response = new MTS_ZResponseHtml();#Brightness 2020-10-20 继承于PhalApi_Response

//注册缓存对象 cache 文件缓存
$di->cache = new PhalApi_Cache_File(['path' => API_ROOT . '/runtime', 'prefix' => 'Brightness', 'enable_file_name_format' => FALSE]);

//必须显式注册，以便可以让服务自行初始化 user token 扩展
$di->userLite = new User_Lite();

//注册验证类
$di->validate = new Tool_Validate();

//视图控制器 需要预设2个参数，第一个参数为该项目名称，第二个参数为视图类型(也就是你有多套模板使用哪一套)
DI()->view = new View_Lite('Brightness', 'Default');
// 翻译语言包设定
SL(isset($_GET['language'])?$_GET['language']:'zh_cn');

// 注册 smarty 类
DI()->smarty = new Smarty_Lite('view');

//注册 公共加密类
DI()->encrypt = new Tool_ZEncrypt();
/** ---------------- 定制注册 可选服务组件 ---------------- **/

/**
// 签名验证服务
$di->filter = 'PhalApi_Filter_SimpleMD5';
 */

/**
// 缓存 - Memcache/Memcached
$di->cache = function () {
    return new PhalApi_Cache_Memcache(DI()->config->get('sys.mc'));
};
 */

/**
// 支持JsonP的返回
if (!empty($_GET['callback'])) {
    $di->response = new PhalApi_Response_JsonP($_GET['callback']);
}
 */
