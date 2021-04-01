<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-30 15:47:48
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-30 18:20:47
 * @Description: smarty 使用
 */



class Api_Smarty extends MTS_WebApi {

    public function getRules()
    {
       
        return array(
           
            'Index'=>array(
              
            ),
            
        );
       
    }

    public function Index()
    {
        $this->title = __FUNCTION__;
        
        $this->view->name = 'Brightness';
        $this->view->list = array(
                    array(
                        "id"   => 1,
                        "name" => "test"
                    ),
                    array(
                        "id"   => 2,
                        "name" => "test2"
                    )
                );
                
    }
   

    
    
  
}

?>