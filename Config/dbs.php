<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-18 15:42:03
 * @LastEditors: Brightness
 * @LastEditTime: 2021-01-22 15:49:47
 * @Description: file content
 */

/**
 * 分库分表的自定义数据库路由配置
 * 
 * @author: dogstar <chanzonghuang@gmail.com> 2015-02-09
 */

return array(
    /**
     * DB数据库服务器集群
     */
    'servers' => array(
        'db_demo' => array(                         //服务器标记
            'host'      => 'localhost',             //数据库域名
            'name'      => 'tp',               //数据库名字
            'user'      => 'root',                  //数据库用户名
            'password'  => '123456',	                    //数据库密码
            'port'      => '3306',                  //数据库端口
            'charset'   => 'UTF8',                  //数据库字符集
        ),
    ),

    /**
     * 自定义路由表
     */
    'tables' => array(
        //通用路由
        // '__default__' => array(
        //     'prefix' => 'tbl_',
        //     'key' => 'id',
        //     'map' => array(
        //         array('db' => 'db_demo'),
        //     ),
        // ),

        '__default__' => array(
            'prefix' => '',
            'key' => 'id',
            'map' => array(
                array('db' => 'db_demo'),
            ),
        ),
        /**
        'demo' => array(                                                //表名
            'prefix' => 'tbl_',                                         //表名前缀
            'key' => 'id',                                              //表主键名
            'map' => array(                                             //表路由配置
                array('db' => 'db_demo'),                               //单表配置：array('db' => 服务器标记)
                array('start' => 0, 'end' => 2, 'db' => 'db_demo'),     //分表配置：array('start' => 开始下标, 'end' => 结束下标, 'db' => 服务器标记)
            ),
        ),
         */
          //5张表，可根据需要，自行调整表前缀、主键名和路由
        'user_session' => array(
            'prefix' => '',
            'key' => 'id',
            'map' => array(
                array('db' => 'db_demo'),
                array( 'db' => 'db_demo'),
            ),
        ),
    ),
);
