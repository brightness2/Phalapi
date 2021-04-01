<?php
/*
 * @Author: Brightness
 * @Date: 2020-10-19 17:03:16
 * @LastEditors: Brightness
 * @LastEditTime: 2021-01-05 17:08:20
 * @Description: 重写返回格式
 */
class MTS_ZResponseHtml extends PhalApi_Response{
    protected $code = 0;#业务错误码
    protected $errmsg = '';#业务错误信息

    /**
     * 构造函数
     *
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function __construct() {
    	$this->addHeaders('Content-Type', 'text/html;charset=utf-8');
    }
    /**
     * 重写返回的数据格式
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function getResult() {
        $rs = array(
            'ret'   => $this->ret,
            'data'  => [
                'code' => $this->code,
                'result' => $this->data,
                'errmsg' => $this->errmsg,
            ],
            'msg'   => $this->msg,
        );

        if (!empty($this->debug)) {
            $rs['debug'] = $this->debug;
        }

        return $rs;
    }
    /**
     * 设置业务错误码 
     *
     * @param int $code
     * @return void
     * @desc 新增的方法
     * @example
     * @author Brightness
     * @since
     */
    public function setCode($code) {
    	$this->code = $code;
    	return $this;
    }
    /**
     * 设置业务错误信息
     *
     * @param string $errmsg
     * @return void
     * @desc 新增的方法
     * @example
     * @author Brightness
     * @since
     */
    public function setErrmsg($errmsg) {
    	$this->errmsg = $errmsg;
    	return $this;
    }
    /**
     * 修改返回格式
     *
     * @param array $result
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function formatResult( $result )
    {
        // if ($result['ret'] != 200)
        // {
        //     header("HTTP/1.1 ".$result['ret']. " " . $result['msg']);
        //     header("Status: ".$result['ret']. " " . $result['msg']);
        //     echo $result['ret']. " " . $result['msg'];
        //     exit;
        // }
        header('Content-type: application/json'); 
        return json_encode( $result );
    }
}
?>