<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-29 16:26:55
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-30 12:50:21
 * @Description: 数据库操作 基础类
 */

abstract class Model_Dbobj implements PhalApi_Model
{
    protected $orm ;

    public function __construct()
    {
        $this->orm =  $this->getORM();
    }
    /**
     * select 查询所有条数
     *
     * @param string $fields 查询的字段
     * @param string $action orm 查询的方法 
     * 操作 	        说明 	                                           示例 	                                         备注 	                            是否PhalApi新增
     * fetch() 	    循环获取每一行 	                           while($row = $user->fetch()) { //... } 	                                                               否
     * fetchOne() 	只获取第一行 	                           $row = $user->where('id', 1)->fetchOne(); 	             等效于fetchRow() 	                           是
     * fetchRow() 	只获取第一行 	                           $row = $user->where('id', 1)->fetchRow(); 	             等效于fetchOne() 	                           是
     * fetchPairs() 获取键值对 	                               $row = $user->fetchPairs('id', 'name'); 	                 第二个参数为空时，可取多个值，并且多条纪录 	  否
     * fetchAll() 	获取全部的行 	                           $rows = $user->where('id', array(1, 2, 3))->fetchAll(); 	 等效于fetchRows() 	                           是
     * fetchRows() 	获取全部的行 	                           $rows = $user->where('id', array(1, 2, 3))->fetchRows();  等效于fetchAll() 	                           是
     * queryAll() 	复杂查询下获取全部的行，默认下以主键为下标 	  $rows = $user->queryAll($sql, $parmas); 	                等效于queryRows() 	                          是
     * queryRows() 	复杂查询下获取全部的行，默认下以主键为下标 	  $rows = $user->queryRows($sql, $parmas); 	                等效于queryAll() 	                          是
     * count() 	    查询总数 	                               $total = $user->count('id'); 	                         第一参数可省略 	                            否
     * min() 	    取最小值 	                               $minId = $user->min('id'); 	                                                                           否
     * max() 	    取最大值 	                               $maxId = $user->max('id'); 	                                                                           否
     * sum()        计算总和 	                               $sum = $user->sum('age'); 	                                                                           否
     * @param string $actionParam 查询的方法的参数
     * @return array
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function setQuery($fields = '*',$action = 'fetchAll',$actionParam = '')
    {
        $needFields = is_array($fields) ? implode(',', $fields) : $fields;
        $this->orm->select($needFields);
        
        return $this->orm->$action($actionParam);
    }

    /**
     * select one 查询一条 
     *
     * @param string $fields 查询的字段
     * @return array
     * @desc  根据条件查询一条数据，子类 addParams 
     * @example
     * @author Brightness
     * @since
     */
    public function getByParams($fields = '*')
    {
        $needFields = is_array($fields) ? implode(',', $fields) : $fields;

        return  $this->orm->fetchOne();
    }

    abstract public function addParams($parmas = array());
    

    /**
     * 排序 ， 分页 ， 分组 
     *
     * @param array $params
     * @return void
     * @desc 子类 addParams 方法内调用 ['order'=>'','limit'=>1,'offset'=>1,'group'=>'','having'=>'']
     * @example
     * @author Brightness
     * @since
     */
    protected function filterParams($params = array())
    {
        //排序
        if(isset($params['order']))
            $this->orm->order($params['order']);

        // 分页  limit offset
        if(isset($params['limit']) and $params['limit'] > 0){
            $offset = null;
            if(isset($params['offset']) and $params['offset'] > 0){
                $offset = $params['offset'];
            }
            
            $this->orm->limit($params['limit'],$offset);
        }
        
        //分组
        if(isset($params['group'])){
            if(isset($params['having'])){
                $this->orm->group($params['group'],$params['having']);

            }else{
                $this->orm->group($params['group']);
            }
        }
        
    }

    /**
     * where
     *
     * @param string $field
     * @param mixed $value
     * @param string $condition
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    protected function where($field,$value,$condition = '=')
    {
       $condition = strtolower(str_replace(' ','',$condition));

       if($condition == 'like'){
            $this->orm->where($field.' LIKE ?','%'.$value.'%');
       }else if($condition == 'notlike'){
            $this->orm->where($field.' NOT LIKE ?','%'.$value.'%');
       }else{
            $this->orm->where($field.' '.$condition.' ?',$value);
       }    

    }

    /**
     * or
     *
     * @param string $field
     * @param mixed $value
     * @param string $condition
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    protected function whereOr($field,$value,$condition = '=')
    {
        $condition = strtolower(str_replace(' ','',$condition));

        if($condition == 'like'){
                $this->orm->or($field.' LIKE ?','%'.$value.'%');
        }else if($condition == 'notlike'){
                $this->orm->or($field.' NOT LIKE ?','%'.$value.'%');
        }else{
                $this->orm->or($field.' '.$condition.' ?',$value);
        }    

    }

    /**
     * in
     *
     * @param string $field
     * @param mixed $arr
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    protected function whereIn($field,$arr)
    {
        if(is_array($arr)){
            $this->orm->where($field, $arr);
        }
        
    }

    /**
     * not in
     *
     * @param string $field
     * @param mixed $arr
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    protected function whereNotIn($field,$arr)
    {
        if(is_array($arr)){
            $this->orm->where('NOT '.$field, $arr);
        }
        
    }

    /**
     * 判断是否为空
     *
     * @param string $field
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    protected  function isNull($field)
    {
            $this->orm->where($field,null);
    }

    /**
     * 判断是否不为空
     *
     * @param string $field
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    protected  function isNotNull($field)
    {
            $this->orm->where($field.' IS NOT ?',null);
    }


    /******* 复制于 PhalApi_Model_NotORM **********/
    protected static $tableKeys = array();

    public function get($id, $fields = '*') {
        $needFields = is_array($fields) ? implode(',', $fields) : $fields;
        $notorm = $this->getORM($id);

        $table = $this->getTableName($id);
        $rs = $notorm->select($needFields)
            ->where($this->getTableKey($table), $id)->fetch();

        $this->parseExtData($rs);

        return $rs;
    }

    public function insert($data, $id = NULL) {
        $this->formatExtData($data);

        $notorm = $this->getORM($id);
        $notorm->insert($data);

        return $notorm->insert_id();
    }

    public function update($id, $data) {
        $this->formatExtData($data);

        $notorm = $this->getORM($id);

        $table = $this->getTableName($id);
        return $notorm->where($this->getTableKey($table), $id)->update($data);
    }

    public function delete($id) {
        $notorm = $this->getORM($id);

        $table = $this->getTableName($id);
        return $notorm->where($this->getTableKey($table), $id)->delete();
    }

    /**
     * 对LOB的ext_data字段进行格式化(序列化)
     */
    protected function formatExtData(&$data) {
        if (isset($data['ext_data'])) {
            $data['ext_data'] = json_encode($data['ext_data']);
        }
    }

    /**
     * 对LOB的ext_data字段进行解析(反序列化)
     */
    protected function parseExtData(&$data) {
        if (isset($data['ext_data'])) {
            $data['ext_data'] = json_decode($data['ext_data'], true);
        }
    }

    /**
     * 根据主键值返回对应的表名，注意分表的情况
     * 
     * 默认表名为：[表前缀] + 全部小写的匹配表名
     *
     * 在以下场景下，需要重写此方法以指定表名
     * + 1. 自动匹配的表名与实际表名不符
     * + 2. 存在分表 
     * + 3. Model类名不含有Model_
     */
    protected function getTableName($id) {
        $className = get_class($this);
        $pos = strpos($className, 'Model');

        $tableName = $pos !== FALSE ? substr($className, $pos + 6) : $className;
        return strtolower($tableName);
    }

    /**
     * 根据表名获取主键名
     *
     * - 考虑到配置中的表主键不一定是id，所以这里将默认自动装配数据库配置并匹配对应的主键名
     * - 如果不希望因自动匹配所带来的性能问题，可以在每个实现子类手工返回对应的主键名
     * - 注意分表的情况
     * 
     * @param string $table 表名/分表名
     * @return string 主键名
     */
    protected function getTableKey($table) {
        if (empty(static::$tableKeys)) {
            $this->loadTableKeys();
        }

        return isset(static::$tableKeys[$table]) ? static::$tableKeys[$table] : static::$tableKeys['__default__'];
    }

    /**
     * 快速获取ORM实例，注意每次获取都是新的实例
     * @param string/int $id
     * @return NotORM_Result
     */
    protected function getORM($id = NULL) {
        $table = $this->getTableName($id);
        return DI()->notorm->$table;
    }

    protected function loadTableKeys() {
        $tables = DI()->config->get('dbs.tables');
        if (empty($tables)) {
            throw new PhalApi_Exception_InternalServerError(T('dbs.tables should not be empty'));
        }

        foreach ($tables as $tableName => $tableConfig) {
            static::$tableKeys[$tableName] = $tableConfig['key'];

            // 分表的主键
            foreach ($tableConfig['map'] as $mapItem) {
                if (!isset($mapItem['start']) || !isset($mapItem['end'])) {
                    continue;
                }

                for ($i = $mapItem['start']; $i <= $mapItem['end']; $i ++) {
                    static::$tableKeys[$tableName . '_' . $i] = $tableConfig['key'];
                }
            }
        }
    }
}
?>