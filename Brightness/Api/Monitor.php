<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-08 10:02:07
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-08 18:13:50
 * @Description: 监控报价单接口
 */
class Api_Monitor extends PhalApi_Api{

    public function getRules()
    {
        // $tokenRules = DI()->config->get('app.apiCommonRules.token');
        // $tokenRules['require'] = false;
        return array(
            // '*'=>['token'=>$tokenRules,],
            'createCustomer'=>array(
                'id'=>['name'=>'customerId','require'=>false,'desc'=>'客户ID'],
                'name'=>['name'=>'name','require'=>true,'desc'=>'客户名称'],
                'sex'=>['name'=>'sex','type'=>'int','default'=>0,'desc'=>'客户性别'],
                'mobile'=>['name'=>'mobile','require'=>true,'desc'=>'联系方式'],
                'openid'=>['name'=>'openid','require'=>false,'desc'=>'微信openid'],
                'address'=>['name'=>'address','require'=>true,'desc'=>'安装地址'],
            ),

            'createOfferParam'=>array(
                'customerId'=>['name'=>'customerId','require'=>true,'desc'=>'客户ID'],
                'id'=>['name'=>'offerId','require'=>false,'desc'=>'报价表编号'],
                'scene'=>['name'=>'scene','type'=>'array','desc'=>'监控场景'],
                'pixel'=>['name'=>'pixel','desc'=>'摄像头像素'],
                'number'=>['name'=>'number','require'=>true,'desc'=>'摄像头数量'],
                'record_time'=>['name'=>'record_time','require'=>true,'desc'=>'录像时间要求'],
            ),

            'createOfferScene'=>array(
                'id'=>['name'=>'offerId','require'=>true,'desc'=>'报价表编号'],
                'prospect'=>['name'=>'prospect','require'=>true,'desc'=>'是否上门勘察环境'],
                'prospect_time'=>['name'=>'prospect_time','require'=>true,'desc'=>'日期'],
                'space'=>['name'=>'space','require'=>true,'desc'=>'空间'],
                'area'=>['name'=>'area','require'=>true,'desc'=>'面积'],

            ),

            'createOfferBusiness'=>array(
                'id'=>['name'=>'offerId','require'=>true,'desc'=>'报价表编号'],
                'invoice_type'=>['name'=>'invoice_type','require'=>true,'desc'=>'发票类型'],
                'invoice_title'=>['name'=>'invoice_title','require'=>false,'desc'=>'发票抬头'],
                'invoice_no'=>['name'=>'invoice_no','require'=>false,'desc'=>'发票税号'],
            ),

        );
    }

    /**
     * 创建客户
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function createCustomer()
    {
       
        $formData = get_object_vars($this);
        $domian = new Domain_Monitor;
        $customerId = $domian->loadCustomer($formData);
        
        return ['customerId'=>$customerId];
    }

    /**
     * 创建设备参数
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function createOfferParam()
    {
        $formData = get_object_vars($this);
        return $formData;
        $domian = new Domain_Monitor;
        $offerId = $domian->loadOffer($formData);
        
        return ['offerId'=>$offerId];
    }

    /**
     * 创建现场环境信息
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function createOfferScene()
    {
        $formData = get_object_vars($this);
        $domian = new Domain_Monitor;
        $res = $domian->loadScene($formData);
        
        return $res;
    }

    /**
     * 创建现场环境信息
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function createOfferBusiness()
    {
        $formData = get_object_vars($this);
        $domian = new Domain_Monitor;
        $res = $domian->loadBusiness($formData);
        
        return $res;
    }
}
?>
