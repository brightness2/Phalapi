<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-08 11:42:30
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-08 17:14:31
 * @Description: 监控报价单接口数据操作
 */
    class Model_MonitorOffer extends PhalApi_Model_NotORM
    {

        protected $orm ;

        protected function getTableName($id) {
            return 'monitor_offer';
        }

        public function __construct()
        {
            $this->orm =  $this->getORM();
        }
        
        /**
         * 新增客户信息
         *
         * @param array $formData
         * @return void
         * @desc
         * @example
         * @author Brightness
         * @since
         */
        public function add($formData)
        {
            $res = $this->orm->insert($formData);
            return $res['id'];
        }

        /**
         * 更新
         *
         * @param array $formData
         * @return void
         * @desc
         * @example
         * @author Brightness
         * @since
         */
        public function update($formData,$id)
        {
            $res = $this->orm->where('id',$id)->update($formData);
            if($res === false) throw new MTS_ZException('更新失败');
            return $id;
        }
        
    }
?>
