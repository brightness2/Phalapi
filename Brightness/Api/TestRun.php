<?php
/*
 * @Author: Brightness
 * @Date: 2020-10-19 14:59:53
 * @LastEditors: Brightness
 * @LastEditTime: 2021-01-25 10:26:28
 * @Description: 测试接口
 */

class Api_TestRun extends PhalApi_Api {

    public function getRules()
    {
        // $tokenRules = DI()->config->get('app.apiCommonRules.token');
        // $tokenRules['require'] = false;
        return array(
            // '*'=>array(
            //     'token'=>$tokenRules,
            // ),
            'test1'=>array(),
            'test2'=>array(),
            'test3'=>array(),
            'test4'=>array(
                'userId'=>['name'=>'id','require'=>true,'desc'=>'用户ID'],
            ),
            'test5'=>array(),
            'test6'=>array(
                'param'=>['name'=>'param','require'=>false,'desc'=>'参数'],
            ),
            'test7'=>array(),
            'test8'=>array(
                'param1'=>['name'=>'param1','require'=>false,'default'=>'1','desc'=>'参数1'],
                'param2'=>['name'=>'param2','require'=>false,'desc'=>'参数2'],
                'param3'=>['name'=>'param3','require'=>false,'default'=>'3','desc'=>'参数3'],
                'param4'=>['name'=>'param4','require'=>false,'default'=>'4','desc'=>'参数4'],
            ),
            'test9'=>array(
                'username'=>['name'=>'username','require'=>true,'desc'=>'用户名'],
                'password'=>['name'=>'password','require'=>true,'desc'=>'密码'],
            ),
            'test10'=>array(),
            'test11'=>array(),
            'test12'=>array(),
            'test13'=>array(),
            'test14'=>array(),
            'test15'=>array(),
            'test16'=>array(),



            
        );
       
    }
    /**
     * 测试1
     *
     * @return void
     * @desc  抛出业务异常
     * @example
     * @author Brightness
     * @since
     */
    public function test1()
    {

        throw new MTS_ZException('Brightness exception');#抛出业务异常
    }
     /**
     * 测试2
     *
     * @return void
     * @desc Lib类
     * @example
     * @author Brightness
     * @since
     */
    public function test2()
    {

        $LIB_OBJECT = new MTS_Lib;#实例化 Libarary/MTS/Lib.php 中的Lib类
        return $LIB_OBJECT->libTest();
  
    }
     /**
     * 测试3
     *
     * @return void
     * @desc 读取配置
     * @example
     * @author Brightness
     * @since
     */
    public function test3()
    {

        return DI()->config->get('app.service_whitelist');
  
    }

      /**
     * 测试4
     *
     * @return void
     * @desc 数据库操作
     * @example
     * @author Brightness
     * @since
     */
    public function test4()
    {
        $domain_user_obj = new Domain_User;
        return $domain_user_obj->getUserById($this->userId);
  
    }

       /**
     * 测试5
     *
     * @return void
     * @desc 日志
     * @example
     * @author Brightness
     * @since
     */
    public function test5()
    {

        $data = array('name' => 'dogstar', 'password' => '123456');
        DI()->logger->error('fail to insert DB', $data);
        DI()->logger->info('fail to insert DB', $data);
        DI()->logger->debug('fail to insert DB', $data);
        DI()->logger->log('test', 'fail to insert DB', $data);
  
    }
    /**
     * 测试6
     *
     * @return void
     * @desc 获取传递的接口参数,
     * @example
     * @author Brightness
     * @since
     */
    public function test6()
    {
        return DI()->request->get('param');
        $rules = $this->getRules();
        return DI()->request->getByRule($rules[__FUNCTION__]['param']);
        return DI()->request->getAll();

    }
    /**
     * 测试7
     *
     * @return void
     * @desc 缓存操作
     * @example
     * @author Brightness
     * @since
     */
    public function test7()
    {   //判断是否注册了cache
        $cache = DI()->cache;
        isset($cache);
        DI()->cache->set('Brightness','test');
        return DI()->cache->get('Brightness');#通常在model层调用缓存
    }
    /**
     * 测试8
     *
     * @return void
     * @desc 批量获取api参数
     * @example
     * @author Brightness
     * @since
     */
    public function test8()
    {
        return get_object_vars($this);
    }
    /**
     * 测试9
     *
     * @return void
     * @desc 登录
     * @example
     * @author Brightness
     * @since
     */
    public function test9()
    {
        
        $domain = new Domain_Login;

        $isLogin = $domain->checkIsLogin();
        if(true == $isLogin) throw new MTS_ZException('你已经登录过!');

        $user = $domain->checkUserName($this->username);
        if(false == $user) throw new MTS_ZException($this->username.' 用户不存在!');
        
        $bool = $domain->checkPassword($this->password,$user['password']);
        if(false == $bool) throw new MTS_ZException('密码错误!');

        $token = Domain_User_User_Session::generate($user['id']);

        return $token;
    }

   /**
    * 测试10
    *
    * @return void
    * @desc 视图模板
    * @example
    * @author Brightness
    * @since
    */
    public function test10() {
        $output = array();
        $output['title'] = '标题';
        $output['list'] = array(
            array(
                'name' => '张三',
                'age' => '15',
            ),
            array(
                'name' => '李四',
                'age' => '22',
            ),
            array(
                'name' => '王五',
                'age' => '35',
            ),
        );

        // 我们现在需要做的事情是在模板中使用，我们先需要在Brightness/View/Default中新建一个index.htm的文件

        //抛出变量
        DI()->view->assign($output);

        //引入模板
        DI()->view->show('index');
    }
    
    /**
     * 测试11
     *
     * @return void
     * @desc 数据库操作2
     * @example
     * @author Brightness
     * @since
     */
    public function test11()
    {
        $model_user = new Model_User;

        $res = $model_user->group();
        return $res;

    }
   
    /**
     * 验证类使用
     *
     * @return void
     * @desc 推荐表单使用数组传递，不使用派框架的形式
     * @example
     * @author Brightness
     * @since
     */
    public function test12()
    {
        $data = ['mobile'=>'454555'];
        $rule = ['mobile'=>'required|mobile'];
        $err = array(
            'mobile'=>['mobile'=>'需要手机号格式'],
        );

        $res = DI()->validate->check($data,$rule,$err);
        return $res;
    }
    
    /**
     * 数据库锁操作
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function test13()
    {
       $user_orm = DI()->notorm->user->lock(); //锁定表,不能修改
    
       $user = $user_orm->select('*')->fetchAll();#SELECT * FROM user FOR UPDATE;
        try{
            $res = $user_orm->where('id',9)->update(['username'=>'test333']);#抛出异常，不可修改数据

        }catch(Exception $e){
            $user_orm2 = DI()->notorm->user;
           return $res = $user_orm2->where('id',9)->update(['username'=>'test333']);#可以执行，不同的notorm对象


        }
        return $res;
    }

    /**
     * notorm 的加操作
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function test14()
    {
        //level 字段值在原值上加上1
      return  DI()->notorm->user->where('id', 9)->update(array('level' => new NotORM_Literal("level + 1")));
      #生成sql:  UPDATE user SET level = levle + 1 WHERE (id = 9);

    }

    /**
     * notorm 事务操作
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function test15()
    {
        //Step 1: 开启事务

        DI()->notorm->beginTransaction('db_demo');#dbs.php 配置文件 db_demo
        //Step 2: 处理业务
        try{
            $user = DI()->notorm->user;
            $lleft = DI()->notorm->lleft;
            $user->insert(array('username' => 'test3'));
            $lleft->insert(['lefttext'=>'test']);
            throw new MTS_ZException('dfdfd');
        }catch(Exception $e){
            //Step 3: 回滚
            DI()->notorm->rollback('db_demo');
            if($e  instanceof MTS_ZException) throw new MTS_ZException($e->getMessage());
            DI()->logger->debug(DI()->request->getService().' test error',$e->getMessage());
            throw new MTS_ZException('操作失败');;
        }
        //Step 3: 提交
        DI()->notorm->commit('db_demo');
        
        return '提交/回滚 必须执行其一，否则下次执行会报PDO There is no active transaction';

    }
    /**
     * 全局常量
     *
     * @return void
     * @desc 在 /Library/MTS/GlobalVar.php 定义
     * @example
     * @author Brightness
     * @since
     */
    public function test16()
    {
        return D_S;
    }

    /**
     * 语言翻译，多语言
     *
     * @return void
     * @desc   /Public/Zinit.php 文件 翻译语言包设定 SL('zh_cn');
     * @example
     * @author Brightness
     * @since
     */
    public function test17()
    {
        return T('author{name},age{age}',['name'=>'Brightness','age'=>18]);
    }
}

?>