<?php
class AOP_AspectTargerProxy
{
    protected $ref = null;
    public $targerObj = null;
    protected $aspectFamily = null;


    public function createTarger($targerObj, $aspectObjArr = [])
    {
        if (!is_object($targerObj)) {
            throw new Exception('$targerObj must be a object');
        }
        $this->targerObj = $targerObj;
        $this->ref = new ReflectionClass($targerObj);
        $aspectObjArr = $this->_filterAspectObj($aspectObjArr);
        $af = AOP_AspectFactory::createAspectFamily($aspectObjArr);
        $this->aspectFamily = $af;
        return $this->targerObj;
    }

    public function __call($method, $args)
    {
        $result = null;
        $this->aspectFamily->before($args);



        if (!$this->ref->hasMethod($method)) {
            throw new Exception($this->ref->getName()
                . ' not has ' . $method . ' function ');
        }
        $med = $this->ref->getMethod($method);
        if (!$med->isAbstract() and $med->isPublic()) {
            if ($med->isStatic()) {
                $result =  $med->invoke(null, ...$args);
            } else {
                $result =  $med->invoke($this->targerObj, ...$args);
            }
        } else {
            throw new Exception($this->ref->getName()
                . ' not has ' . $method . ' function must public');
        }


        $this->aspectFamily->after($args, $result);

        return $result;
    }

    /**
     * 过滤符合的aspect 类
     *
     * @param [type] $aspectObjArr
     * @return void
     */
    private static function _filterAspectObj($aspectObjArr)
    {
        $asArr = [];
        foreach ($aspectObjArr as $aspect) {
            $obj = null;

            if (is_string($aspect)) {
                if (!class_exists($aspect)) {
                    throw new Exception($aspect . '类不存在');
                }
                $obj = new $aspect;
                if (!$obj instanceof AOP_IAspect) {
                    throw new Exception($aspect . '类没有实现接口IAspect');
                }
            } else if (is_object($aspect) and $aspect instanceof AOP_IAspect) {
                $obj = $aspect;
            } else {
                throw new Exception('aspectObjArr 参数必须是类或字符串的集合');
            }

            $asArr[] = $obj;
        }

        return $asArr;
    }
}
