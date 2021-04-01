<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-08 11:39:50
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-08 17:33:09
 * @Description: 监控报价单接口业务
 */
class Domain_Monitor{

    public function getUserById( $userId )
    {
        $USER_OBJECT = new Model_User;#数据库操作
        $res =  $USER_OBJECT->get($userId);
        // $res =  $USER_OBJECT->getByUserId($userId);

        if( false == $res ) throw new MTS_ZException(T('user not exists'));
        return $res;
    }


    /**
     * 创建客户信息
     *
     * @param array $formData
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function loadCustomer($formData)
    {
        
        $dbobj = new Model_Customer;
        try{
            if(isset($formData['id']) &&  $formData['id']){
                $res = $dbobj->update($formData,$formData['id']);
            }else{
                $res = $dbobj->add($formData);
            }
        }catch(Exception $e)
        {
            DI()->logger->debug('Domain_Monitor.createCustomer error',$e->getMessage());
            throw new MTS_ZException('数据写入失败');
        }

        return $res;
    }

    /**
     * 创建参数信息
     *
     * @param array $formData
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function loadOffer($formData)
    {
        $customerDbobj = new Model_Customer;
        $customer = $customerDbobj->get($formData['customerId']);
        if(!$customer) throw new MTS_ZException('找不到客户信息');
        unset($formData['customerId']);
        $formData['customer'] = $customer['name'];
        $formData['address'] = $customer['address'];
        $formData['mobile'] = $customer['mobile'];

        $offerDbobj = new Model_MonitorOffer;
        try{
            if($formData['id']){
                $res = $offerDbobj->update($formData,$formData['id']);
            }else{
                $res = $offerDbobj->add($formData);
            }
        }catch(Exception $e)
        {
            DI()->logger->debug('Domain_Monitor.createCustomer error',$e->getMessage());
            throw new MTS_ZException('数据写入失败');
        }

        return $res;
    }

    /**
     * 创建场景信息
     *
     * @param array $formData
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function loadScene($formData)
    {
        $offerDbobj = new Model_MonitorOffer;
        return $offerDbobj->update($formData,$formData['id']);
    }
    
    
    /**
     * 创建商务信息
     *
     * @param array $formData
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function loadBusiness($formData)
    {
        if($formData['invoice_type'] and !$formData['invoice_title'])
            throw new MTS_ZException('请填写发票抬头');
        $offerDbobj = new Model_MonitorOffer;
        return $offerDbobj->update($formData,$formData['id']);
    }
}
?>
