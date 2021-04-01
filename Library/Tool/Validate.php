<?php
/*
 * @Author: Brightness
 * @Date: 2020-04-27 15:35:36
 * @LastEditors: Brightness
 * @LastEditTime: 2021-01-14 09:51:37
 * @Description: 数据验证类
 */

class Tool_Validate
{
  	// 验证规则
    protected $rules = array(
      // 验证是否为空
      'required',

      // 匹配邮箱
      'email',

      // 匹配身份证
      'idcode',

      // 匹配数字
      'number',

      // 匹配http地址
      'http',

      // 匹配qq号
      'qq',

      //匹配中国邮政编码
      'postcode',

      //匹配ip地址
      'ip',

      //匹配电话格式
      'telephone',

      // 匹配手机格式
      'mobile',

      //匹配26个英文字母
      'en_word',

      // 匹配只有中文
      'cn_word',

      // 验证账户(字母开头，由字母数字下划线组成，4-20字节)
      'user_account',
      //验证数值
      'float',
      //验证日期
      'date',
    );

    //默认错误信息
    protected $errMsg = array(
          // 验证是否为空
          'required'=>'不能为空',

          // 匹配邮箱
          'email'=>'不符合邮箱格式',

          // 匹配身份证
          'idcode'=>'不符合身份证号格式',

          // 匹配数字
          'number'=>'不是数字',

          // 匹配http地址
          'http'=>'不符合http格式',

          // 匹配qq号
          'qq'=>'不符合QQ号格式',

          //匹配中国邮政编码
          'postcode'=>'不符合中国邮政编码格式',

          //匹配ip地址
          'ip'=>'不符合ip格式',

          //匹配电话格式
          'telephone'=>'不符合电话号码格式',

          // 匹配手机格式
          'mobile'=>'不符合手机号码格式',

          //匹配26个英文字母
          'en_word'=>'只能是字母',

          // 匹配只有中文
          'cn_word'=>'只能是中文',

          // 验证账户(字母开头，由字母数字下划线组成，4-20字节)
          'user_account'=>'只能是字母开头，由字母数字下划线组成，4-20字节',
          //验证数值
          'float'=>'只能是正数',
          //验证日期
          'date'=>'日期格式 yyyy-MM-dd',
    );

  /**
   * 检测数据
   *
   * @param array $data_arr 一维数组数据
   * @param array $rules    一维数组，内置规则
   * @param array $err_msg 二维数组 举例 ：$err_msg = array('name'=>array(	'required'=>'缺失name',),);
   * @return 检查通过返回true，不通过返回错误信息
   * @desc
   * @example
   * @author Brightness
   * @since
   */
   public  function check($data_arr,$rules,$err_msg=array()){
      //参数不能是空数组
       if(empty($data_arr)) return false;
       if(empty($rules)) return false;

      //遍历数据，检测每个数据
       foreach($data_arr as $arr_key =>$data){
           $check_rule_arr = $this->explodeRules($rules[$arr_key]);#分割验证规则

           if(!empty($check_rule_arr)){
              //遍历每个要验证的规则
              foreach($check_rule_arr as $rule_key=>$rule){
                $nowRule = strtolower($rule);
                if( !in_array($nowRule, $this->rules)) return 'rule name "'.$nowRule.'" is not found!';#不存在的规则，提示没有该规则
                $result = $this->$nowRule($data);#执行验证
                if(!$result) return $err_msg[$arr_key][$nowRule]?$err_msg[$arr_key][$nowRule]:$arr_key.$this->errMsg[$nowRule];#不符合规则，返回错误信息，没有设置错误信息，使用默认错误信息
              }

           }

        }

        return true;#所有数据验证通过
  }
  /**
   * 分割要检测的规则
   *
   * @param string $str 验证规则字符串，“|”分割的字符串
   * @return array
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  protected function explodeRules($str){
    if(trim($str) == '') return false;
    return  $arr = explode('|',$str);
  }


      // 验证是否为空
      public function required($str){
        $str = trim($str);
        if( $str != "" and $str != null) return true;
        return false;
      }

      // 验证邮件格式
      public function email($str){
        if(preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $str)) return true;
        else return false;
      }

      // 验证身份证
      public function idcode($str){
        if(preg_match("/^\d{14}(\d{1}|\d{4}|(\d{3}[xX]))$/", $str)) return true;
        else return false;
      }

      // 验证http地址
      public function http($str){
        if(preg_match("/[a-zA-Z]+:\/\/[^\s]*/", $str)) return true;
        else return false;
      }

      //匹配QQ号(QQ号从10000开始)
      public function qq($str){
        if(preg_match("/^[1-9][0-9]{4,}$/", $str)) return true;
        else return false;
      }

      //匹配中国邮政编码
      public function postcode($str){
        if(preg_match("/^[1-9]\d{5}$/", $str)) return true;
        else return false;
      }

      //匹配ip地址
      public function ip($str){
        if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $str)) return true;
        else return false;
      }

      // 匹配电话格式
      public function telephone($str){
        if(preg_match("/^\d{3}-\d{8}$|^\d{4}-\d{7}$/", $str)) return true;
        else return false;
      }

      // 匹配手机格式
      public function mobile($str){
        if(preg_match("/^(13[0-9]|15[0-9]|18[0-9])\d{8}$/", $str)) return true;
        else return false;
      }

      // 匹配26个英文字母
      public function en_word($str){
        if(preg_match("/^[A-Za-z]+$/", $str)) return true;
        else return false;
      }

      // 匹配只有中文
      public function cn_word($str){
        if(preg_match("/^[\x80-\xff]+$/", $str)) return true;
        else return false;
      }

      // 验证账户(字母开头，由字母数字下划线组成，4-20字节)
      public function user_account($str){
        if(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,19}$/", $str)) return true;
        else return false;
      }

      // 验证数字
      public function number($str){
        if(preg_match("/^[0-9]+$/", $str)) return true;
        else return false;
      }

      //验证数值
      public function float($str){
        if(preg_match("/^(\d*)(\.\d*)?|0/",$str)) return true;
        else return false;
      }

      //验证日期
      public function date($date){
            if(!$date OR empty($date) == '' OR $date == null) return true;
            //匹配日期格式
           if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
           {
               //检测是否为日期
               if(checkdate($parts[2],$parts[3],$parts[1]))
                   return true;
               else
               return false;
           }
           else
               return false;

      }
}

 ?>
