<?php
class Api_Aop extends PhalApi_Api
{
    public function getRules()
    {
        return array(

            'test' => array(),
        );
    }

    public function test()
    {
        $porxy = new AOP_AspectTargerProxy();
        $domin = $porxy->createTarger(new Domain_TestTarger, ['Aspect_Test']);
        return $porxy->targer('test AOP');
    }
}
