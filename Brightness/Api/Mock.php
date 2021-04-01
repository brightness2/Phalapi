<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-29 15:16:57
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-31 21:18:37
 * @Description: 接口模拟,处理接口数据的校验，数据的结构重整
 */


class Api_Mock extends PhalApi_Api {

    public function getRules()
    {
       
        return array(
           
            'form'=>array(
               'data'=>['name'=>'data','type'=>'array','desc'=>'表单数据'],
            ),
            'test'=>array(
                'data'=>['name'=>'data','type'=>'array','require'=>true,'desc'=>'表单数据'],
            ),
            'leftJoin'=>array(
                
            ),
        );
       
    }

    public function leftjoin()
    {

        $customer_dbobj = new Model_MyOffer();
        return $customer_dbobj->getByParams('monitor_offer.*,lleft.lefttext AS TEXT,monitor_image.image AS IMG');
    }


    public function test()
    {
        
        // if(count($this->data) == 1  and $this->data[0] == ''){#没有数据时为 null
        //     throw new MTS_ZException('缺少表单数据');
        // }

        $rule = ['id'=>'required|number'];
        $err = array(
            'id'=>['number'=>'id需要是整数'],
        );
        $valid_res = DI()->validate->check($this->data,$rule,$err);
        
        if(true !== $valid_res) throw new MTS_ZException($valid_res);
        
        $domain = new Domain_Mock();
        return $domain->getById($this->data['id']);
    }

    /**
     * 模拟表单处理
     *
     * @return void
     * @desc  
     * @example
     * @author Brightness
     * @since
     */
    public function form()
    {

       
        $res = false;
        $rule = ['mobile'=>'required|mobile'];
        $err = array(
            'mobile'=>['mobile'=>'需要手机号格式'],
        );
        if(!$this->data){#没有数据时为 null
            return $res;
        }
        $valid_res = DI()->validate->check($this->data,$rule,$err);
        if(true != $valid_res) throw new MTS_ZException($valid_res);

        $domain = new Domain_Mock;
        $res = $domain->getUserById($this->data['id']);
        return $res;
    }
   
    
}

?>