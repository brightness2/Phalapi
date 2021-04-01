<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-29 16:44:40
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-31 10:32:45
 * @Description: dbobj 类 数据库操作
 */
class Model_MyOffer  extends MTS_ZDbobj {

    public function getTableName($id)
    {
        return 'monitor_offer';
    }

    public function addParams($params = array())
    {
        $this->filterParams($params);

        if(isset($params['id']))
            $this->where('id',$params['id']);
        

    }
}
?>
