{$topPage}
<!--
 * @Author: Brightness
 * @Date: 2020-12-30 15:49:58
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-31 08:48:35
 * @Description: smarty index 页面 ，嵌套顶部，底部页面
-->

<br>
<style type="text/css">
    p,table{
        margin: auto;
        width: 60%;
    }
</style>
Hello {$name}, welcome to smarty<br/>

<table border="1">
    {foreach  $list as $item}
        <tr>
            <td>{$item.id}</td>
            <td>{$item.name}</td>
        </tr>
    {/foreach}
</table>
<br>
{$bottomPage}
