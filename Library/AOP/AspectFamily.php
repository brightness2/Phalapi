<?php
class AOP_AspectFamily implements AOP_IAspect
{

    private $_aspectArray = [];

    public function addAspect($aspectObj)
    {
        $this->_aspectArray[] = $aspectObj;
    }

    public function before($args = null)
    {
        foreach ($this->_aspectArray as $aspectObj) {
            $aspectObj->before($args);
        }
    }

    public function after($args = null, $result = null)
    {
        foreach ($this->_aspectArray as $aspectObj) {
            $aspectObj->after($args, $result);
        }
    }
}
