<?php /* Smarty version Smarty-3.0.8, created on 2019-12-15 19:33:24
         compiled from "C:\wamp64\www/view/home.html" */ ?>
<?php /*%%SmartyHeaderCode:12561595665df66054a35c81-67668573%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8df543e2b6c78779e414812ffbf6d38be98e9177' => 
    array (
      0 => 'C:\\wamp64\\www/view/home.html',
      1 => 1576330858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12561595665df66054a35c81-67668573',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('header')->value;?>

<?php echo $_smarty_tpl->getVariable('menu')->value;?>

<div id="content">

  <?php if ($_smarty_tpl->getVariable('slide')->value){?>
      <!-- slider -->
    <div id="slider">
      <div class="container slider">
        <div class="row">
                  <div class="box col-xs-12 col-md-10 col-md-offset-1 noPadding">
                  <div id="slideImage" class="owl-carousel">
                         <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('slide')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                         <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                             <div class="item">
                                 <a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
">
                                     <img src="<?php echo $_smarty_tpl->tpl_vars['i']->value['image'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" width="963" height="412"/>
                                     <div class="slideShadow"><h1><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</h1></div>
                                 </a>
                             </div>
                        <?php }} ?>
                        <?php }} ?>
                     </div>
                     <div id="slideThumbImage" class="owl-carousel">
                       <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('slide')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                       <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                          <div class="item"><img src="<?php echo $_smarty_tpl->tpl_vars['i']->value['image_thumb'];?>
" title="" alt="" width="116" height="50"/></div>
                        <?php }} ?>
                        <?php }} ?>
                     </div>
                  </div>
        </div>
      </div>
    </div>
  <?php }?>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

