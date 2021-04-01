<?php
interface AOP_IAspect
{
    public function before($args = null);

    public function after($args = null, $result = null);
}
