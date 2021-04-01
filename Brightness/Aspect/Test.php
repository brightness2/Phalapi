<?php
class Aspect_Test implements AOP_IAspect
{
    public function before($args = null)
    {
        // throw new MTS_ZException('进入test aspect before');
    }

    public function after($args = null, $result = null)
    {
        throw new MTS_ZException('进入test aspect after <br/>' . 'result ' . $result);
    }
}
