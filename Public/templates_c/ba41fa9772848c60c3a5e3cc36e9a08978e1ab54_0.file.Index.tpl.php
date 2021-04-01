<?php
/* Smarty version 3.1.29, created on 2020-12-31 08:48:37
  from "D:\www\webroot\PiRelease\Public\view\Smarty\Index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5fed1fe59e8d29_47972060',
  'file_dependency' => 
  array (
    'ba41fa9772848c60c3a5e3cc36e9a08978e1ab54' => 
    array (
      0 => 'D:\\www\\webroot\\PiRelease\\Public\\view\\Smarty\\Index.tpl',
      1 => 1609375715,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5fed1fe59e8d29_47972060 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['topPage']->value;?>

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
Hello <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
, welcome to smarty<br/>

<table border="1">
    <?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_item_0_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_0_saved_local_item = $_smarty_tpl->tpl_vars['item'];
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
        </tr>
    <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_local_item;
}
if ($__foreach_item_0_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_item;
}
?>
</table>
<br>
<?php echo $_smarty_tpl->tpl_vars['bottomPage']->value;?>

<?php }
}
