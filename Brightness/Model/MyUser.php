<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-29 16:44:40
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-31 09:48:32
 * @Description: dbobj 类 数据库操作
 */
class Model_MyUser  extends MTS_ZDbobj {

    public function getTableName($id)
    {
        return 'user';
    }

    public function addParams($params = array())
    {
        $this->filterParams($params);

        if(isset($params['id']))
            $this->where('id',$params['id']);
        if(isset($params['level']))
            $this->whereOr('level',$params['level']);

        // $this->where('username','u','not like');
        // $this->whereOr('username','B','like');
        // $this->whereNotIn('id',[1]);

    }
}
?>
