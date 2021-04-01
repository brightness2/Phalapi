<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-29 16:26:55
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-30 18:22:08
 * @Description: web 页面基础类，结合smarty 实现
 */

 class MTS_WebApi extends PhalApi_Api
{
  
    protected $view = null ;#smarty 的模板数据 param
    protected $title = '';#页面标题
    protected $topPage = 'top';#顶部 页面
    protected $bottomPage = 'bottom';#底部 页面
    
    public function __construct()
    {
        $this->view = new stdClass();
    }
    

    public function __destruct()
    {
        $this->view->title = $this->title;#页面标题
        
        DI()->smarty->setParams($this->view);
        //引入顶部页面
        if($this->topPage)
            DI()->smarty->parse('topPage','../Layout/'.$this->topPage.".tpl");#文件路径 Public\view\Layout\
        //引入底部页面
        if($this->bottomPage)
            DI()->smarty->parse('bottomPage','../Layout/'.$this->bottomPage.".tpl");

        DI()->smarty->show();#页面显示
        
    }

   
}
?>