<?php
class AOP_AspectFactory
{

    public static function createAspectFamily($aspectObjArr = [])
    {
        // $aspectObjArr = self::_filterAspectObj($aspectObjArr);
        $aspectFamily = new AOP_AspectFamily();
        if (is_array($aspectObjArr) and count($aspectObjArr) > 0) {
            foreach ($aspectObjArr as $aspectObj) {
                $aspectFamily->addAspect($aspectObj);
            }
        }

        return $aspectFamily;
    }

    // /**
    //  * 过滤符合的aspect 类
    //  *
    //  * @param [type] $aspectObjArr
    //  * @return void
    //  */
    // private static function _filterAspectObj($aspectObjArr)
    // {
    //     $asArr = [];
    //     foreach ($aspectObjArr as $aspect) {

    //         if (is_string($aspect)) {
    //             if (!class_exists($aspect)) {
    //                 throw new Exception($aspect . '类不存在');
    //             }
    //             $obj = new $aspect;
    //             if (!$obj instanceof IAspect) {
    //                 throw new Exception($aspect . '类没有实现接口IAspect');
    //             }
    //             $asArr[] = $obj;
    //         } else if (is_object($aspect) and $aspect instanceof IAspect) {
    //             $asArr[] = $aspect;
    //         } else {
    //             throw new Exception('aspectObjArr 参数必须是类或字符串的集合');
    //         }
    //     }

    //     return $asArr;
    // }
}
