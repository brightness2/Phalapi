<?php
/*
 * @Author: Brightness
 * @Date: 2020-08-31 15:51:51
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-23 21:57:27
 * @Description: 静态缓存
 */

class Tool_Cache{

    public $dir = '';#缓存的文件夹
    public $ext = '';#文件后缀
    /**
     * 构造函数
     *
     * @param string $dir 缓存的文件夹
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function __construct($dir='',$ext='')
    {   
        $this->dir = $dir?$dir:DI()->config->get('app.cache.default_dir');
        $this->ext = $ext?$ext:DI()->config->get('app.cache.file_ext');
    }
    /**
     *  读取静态缓存
     *
     * @param string $key 缓存标识
     * @desc
     * @example
     * @author Brightness
     * @since
     * @return bool/array 
     */
    public function get($key)
    {
        $fileName =  $this->fileName($key);
        if(!is_file($fileName)){
            DI()->logger->info('Domain_Cache->get warn! cache file is not exists',$fileName);
            return false;
        }
        $contents = file_get_contents($fileName);
        $exTime = (int)substr($contents,0,11);
        $check_bool = $this->checkExTime($exTime,$fileName);
        if(!$check_bool) return false;
        $value = json_decode(substr($contents,11),true);
        return $value;
    }
   /**
    * 设置静态缓存
    *
    * @param array/string $data 缓存数据
    * @param string $key 缓存标识
    * @param integer $time 缓存有效时间 单位秒
    * @return bool
    * @desc
    * @example
    * @author Brightness
    * @since
    */
    public function set($data,$key,$time=0)
    {
       if(is_array($data) OR is_string($data)){
            $fileName = $this->fileName($key); 
            if(!$fileName) return false;
            $cacheTime = sprintf('%011d',$time);
            file_put_contents($fileName,$cacheTime.json_encode($data));
            return true;
       }else{
           DI()->logger->info('Domain_Cache->set warn! cache data is not array or string',$data);
           return false;
       }
    }
    /**
     * 删除静态缓存
     *
     * @param string $key 缓存标识
     * @return bool
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function delete($key)
    {
        $fileName = $this->fileName($key);
        return @unlink($fileName);
    }
   /**
    * 拼接文件名
    *
    * @param string $key 缓存标识
    * @return string/bool 
    * @desc
    * @example
    * @author Brightness
    * @since
    */
    protected function fileName($key)
    {
        $bool = true;
        if(!is_dir($this->dir)) $bool = mkdir($this->dir,0777,true);
        if($bool) return $this->dir.$key.'.'.$this->ext;
        DI()->logger->info('Domain_Cache->fileName warn!cache dir is not exists',$this->dir);
        return false;
    }
    /**
     * 检测缓存是否过期
     *
     * @param integer $exTime 有效时间 单位秒
     * @param string $fileName 缓存文件
     * @return bool
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    protected function checkExTime($exTime,$fileName)
    {
        
        if(0 != $exTime AND (filemtime($fileName)+$exTime) < time()){
            @unlink($fileName);
            return false;
        }
        return true;
    }
}