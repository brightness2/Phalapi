<?php
/*
 * @Author: Brightness
 * @Date: 2020-10-20 15:28:48
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-02 14:21:14
 * @Description: 持久层 数据库操作
 */
class Model_User extends PhalApi_Model_NotORM
{
    protected $orm ;

    public function __construct()
    {
        $this->orm =  $this->getORM();
    }

    protected function getTableName($id) {
        return 'user';
    }
   
    public function getByUserId($id)
    {
        return DI()->notorm->user->select('*')->where('id = ?', $id)->fetch();
    }

  
    public function getByUserName($name)
    {
        return DI()->notorm->user->select('*')->where('username = ?', $name)->fetch();
    }

    //数据库操作例子
    /**
     * SELECT
     *
     * @param string $field  单个字段:'id';多个字段:'id, name, age';字段别名获取:'id, name, MAX(age) AS max_age'
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function select($field)
    {
       return $this->orm->select($field);

        
    }

    /**
     * WHERE
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function where()
    {

        return $this->orm->where('id',1);

        /*单个字段查询：*/
        // WHERE id = 1
        // $this->orm->where('id', 1);
        // $this->orm->where('id = ?', 1);
        // $this->orm->where(array('id', 1));


        /* 多个字段查询：*/
        # WHERE id > 1 AND age > 18

        // $this->orm->where('id > ?', 1)->where('age > ?', 18);
        // $this->orm->and('id > ?', 1)->and('age > ?', 18);
        // $this->orm->where('id > ? AND age > ?', 1, 18);
        // $this->orm->where(array('id > ?' => 1, 'age > ?' => 10));
        // WHERE name = 'dogstar' AND age = 18
        // $this->orm->where(array('name' => 'dogstar', 'age' => 18));

        # WHERE name = 'dogstar' OR age = 18

        // $this->orm->or('name', 'dogstar')->or('age', 18);

        // WHERE ((name = ? OR id = ?)) AND (note = ?) -- 'dogstar', '1', 'xxx'
        #实现方式1：使用and拼接
        // $this->orm->where('(name = ? OR id = ?)', 'dogstar', '1')->and('note = ?', 'xxx');
        #实现方式2：只使用where，不用数组传参
        // $this->orm->where('(name = ? OR id = ?) AND note = ?', 'dogstar', '1', 'xxx');
        #实现方式3：只使用where，用下标为顺序数字的数组传参
        // $this->orm->where('(name = ? OR id = ?) AND note = ?', array('dogstar', '1', 'xxx'));
        #实现方式4：只使用where，用下标为标识符的数组传参
        // $this->orm->where('(name = :name OR id = :id) AND note = :note', array(':name' => 'dogstar', ':id' => '1', ':note' => 'xxx'));

        /*保留状态的写法：*/

        // $this->orm = $notorm->user;  //获取一个新的实例
        // $this->orm->where('age > ?', 18);
        // $this->orm->where('name LIKE ?', '%dog%');  //相当于age > 18 AND name LIKE '%dog%'

        /* 不保留状态的写法：*/

        // $this->orm = $notorm->user;  //获取一个新的实例
        // $this->orm->where('age > ?', 18);

        // $this->orm = $notorm->user;  //重新获取新的实例
        // $this->orm->where('name LIKE ?', '%dog%');  //此时只有 name LIKE '%dog%'
    }

    /**
     * IN查询：
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function in()
    {
        // WHERE id IN (1, 2, 3)
        return $this->orm->where('id', array(1, 2, 3));

        // WHERE id NOT IN (1, 2, 3)
        // $this->orm->where('NOT id', array(1, 2, 3));

        // WHERE (id, age) IN ((1, 18), (2, 20))
        // $this->orm->where('(id, age)', array(array(1, 18), array(2, 20)));
    }

    /**
     * 模糊匹配查询：
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function like()
    {
        // WHERE name LIKE '%dog%'
       return $this->orm->where('username LIKE ?', '%ness%');

        // WHERE name NOT LIKE '%dog%'
        // $this->orm->where('name NOT LIKE ?', '%dog%');
    }

    /**
     * NULL判断查询
     *
     * @return boolean
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function isNull()
    {
        // WHERE (name IS NULL)
       return $this->orm->where('username', null);
    }

    /**
     * ORDER BY
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function orderBy()
    {
        /*单个字段排序：*/
        // ORDER BY id
        return $this->orm->order('id');

        // ORDER BY age DESC
        // $this->orm->order('age DESC');

        /*多个字段排序：*/ 
        // ORDER BY id, age DESC
        //$this->orm->order('id')->order('age DESC');
        //$this->orm->order('id, age DESC');
    }

    /**
     * LIMIT
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function limit()
    {
        /*按数量限制*/
       return  $this->orm->limit(1);

        /* 按数量和偏移量限制（请注意：先偏移量、再数量）*/
        // LIMIT 2,10
        $this->orm->limit(2, 10);
    }

    /**
     * GROUP BY和HAVING
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function group()
    {
        /**不带HAVING： */
        // GROUP BY note
       return $this->orm->group('username');
        /**带HAVING： */
        // GROUP BY note HAVING age > 10
        $this->orm->group('note', 'age > 10');
    }

    /**
    * 1.20.3 CURD之查询类（Retrieve）
    * 操作 	说明 	示例 	备注 	是否PhalApi新增
    * fetch() 	循环获取每一行 	while($row = $user->fetch()) { *... } 	否
    * fetchOne() 	只获取第一行 	$row = $user->where('id', 1)->fetchOne(); 	等效于fetchRow() 	是
    * fetchRow() 	只获取第一行 	$row = $user->where('id', 1)->fetchRow(); 	等效于fetchOne() 	是
    * fetchPairs() 	获取键值对 	$row = $user->fetchPairs('id', 'name'); 	第二个参数为空时，可取多个值，并且多条纪录 	否
    * fetchAll() 	获取全部的行 	$rows = $user->where('id', array(1, 2, 3))->fetchAll(); 	等效于fetchRows() 	是
    * fetchRows() 	获取全部的行 	$rows = $user->where('id', array(1, 2, 3))->fetchRows(); 	等效于fetchAll() 	是
    * queryAll() 	复杂查询下获取全部的行，默认下以主键为下标 	$rows = $user->queryAll($sql, $parmas); 	等效于queryRows() 	是
    * queryRows() 	复杂查询下获取全部的行，默认下以主键为下标 	$rows = $user->queryRows($sql, $parmas); 	等效于queryAll() 	是
    * count() 	查询总数 	$total = $user->count('id'); 	第一参数可省略 	否
    * min() 	取最小值 	$minId = $user->min('id'); 	否
    * max() 	取最大值 	$maxId = $user->max('id'); 	否
    * sum() 	计算总和 	$sum = $user->sum('age'); 	否
    */


    /**
     * 1.20.4 CURD之插入类（Create）
    * 操作 	说明 	示例 	备注 	是否PhalApi新增
    * insert() 	插入数据 	$user->insert($data); 	原生态操作需要再调用insert_id()获取插入的ID 	否
    * insert_multi() 	批量插入 	$user->insert_multi($rows); 	可批量插入 	否
    * insert_update() 	插入/更新 	接口签名：insert_update(array $unique, array $insert, array $update = array() 	不存时插入，存在时更新 	否
     */

     /**
      * 1.20.5 CURD之更新类（Update）
      *  操作 	说明 	示例 	备注 	是否PhalApi新增
      *  update() 	更新数据 	$user->where('id', 1)->update($data); 	更新异常时返回false，数据无变化时返回0，成功更新返回1 	否
      */

    /**
     * 1.20.6 CURD之删除类（Delete）
    * 操作 	说明 	示例 	备注 	是否PhalApi新增
    * delete() 	删除 	$user->where('id', 1)->delete(); 	禁止无where条件的删除操作 	否
     */
}
?>