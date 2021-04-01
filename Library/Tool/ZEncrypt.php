<?php
/*
 * @Author: Brightness
 * @Date: 2021-01-06 11:24:09
 * @LastEditors: Brightness
 * @LastEditTime: 2021-01-07 14:20:03
 * @Description: 公共加密类
 */

 class Tool_ZEncrypt {
     protected $prefix = 'Brightness';#前缀

     public function __construct($prefix = 'Brightness')
     {
         $this->prefix = $prefix;
     }
     /**
      * id字段加密算法
      *
      * @param string $string
      * @return string
      * @desc
      * @example
      * @author Brightness
      * @since
      */
     public function encodeId($string)
     {
         return base64_encode($this->prefix.$string);
     }

     /**
      * id字段解密算法
      *
      * @param string $string
      * @return string
      * @desc
      * @example
      * @author Brightness
      * @since
      */
     public function decodeId($string)
     {
         $string =  base64_decode($string);
         return explode($this->prefix,$string)[1];
     }
 }
?>
