<?php
/*
 * @Author: Brightness
 * @Date: 2020-09-07 14:30:56
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-23 22:08:40
 * @Description: 上传文件处理
 */

class Tool_UploadFile
{

  public $file;#单个文件
  public $allowType = ['jpg','png','jpeg','image/jpeg','image/png'];#允许上传的文件类型
  protected $saveDir;#文件保存的文件夹
  /**
   * 配置加载
   *
   * @param array $config 配置信息
   * @return void
   * @desc 配置数据对象信息
   * @example
   * @author Brightness
   * @since
   */
  protected function loadConfig($config = array())
	{
		if (is_array($config) && count($config) > 0)
		{
			foreach ($config as $key => $value)
			{
				$this->$key = $value;
			}
		}
  }
  /**
   * 构造函数，把配置转成属性
   *
   * @param array $config 配置信息
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  public function __construct($config=array())
  {
    $this->saveDir = dirname(dirname(dirname(__DIR__))).D_S.'www'.D_S.'upload'.D_S;
    $this->loadConfig($config);
  }

  /**
   * 保存文件
   *
   * @param 文件名称 $fileName
   * @param 文件后缀 $ext
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  public function save()
  {
   
    $month = date('Ym');
    $dir = $this->saveDir.$month.D_S;
    if(!is_dir($dir))  mkdir($dir,0777,true);
    $ext = $this->getFileExt();
    $fileName = time().'_'.rand(100,999).'.'.$ext;
    $filePath = $dir.$fileName;
    
    try{
       move_uploaded_file($this->file['tmp_name'],$filePath);
    }catch(Exception $e){
      DI()->logger->debug('Domain_UploadFile->save error not save file:',$e->getMessage());
      throw new MTS_ZException('文件上传失败，文件保存失败');
    }

    return [
      'filePath'=>$filePath,
      'urlFile' => $month.'/'.$fileName,
    ];
    
  }
  /**
  * 检测文件类型
  *
  * @return void
  * @desc
  * @example
  * @author Brightness
  * @since
  */
  protected function checkType()
  {
    if('*' == $this->allowType) return true;
    if( in_array($this->file['type'],$this->allowType)) return true;
    return false;
  }

  /**
   * 文件错误提示
   *
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  protected function getError(){
    $error = $this->file['error'];
    $res = '';
    switch ($error) {
        case '1':$res = '抱歉,您上传的文件过大';  
            break;
        case '2': $res =  '抱歉,您上传的文件过大';  
            break;
        case '3':$res =  '抱歉,网络原因文件上传错误,请后退重新上传';  
            break;
        case '4': $res = '抱歉,请正确选择文件';  
            break;
        case '6': $res =  '抱歉,系统错误,请联系管理员';  
            break;
        case '7': $res = '抱歉,系统错误,请联系管理员';  
            break;
      
    }
    if($res) throw new MTS_ZException($res);
  }
  /**
   * 存储数据单位转换
   *
   * @param number $size
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  protected function formatBytes($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++)
    $size /= 1024;
    return round($size, 2).$units[$i];
  }
  /**
   * 获取文件后缀
   *
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  protected function getFileExt()
  {
    $arr = explode('.', $this->file['name']);
    $count = count($arr);
    return $arr[$count-1];
  }
}

 ?>
