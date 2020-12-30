<?php /* Smarty version Smarty-3.0.8, created on 2019-12-15 19:35:23
         compiled from "C:\wamp64\www/view/post.html" */ ?>
<?php /*%%SmartyHeaderCode:3659504255df660cb3cdea2-61016662%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96a98a9725899e9a4b3b79853eec18bfefb239ac' => 
    array (
      0 => 'C:\\wamp64\\www/view/post.html',
      1 => 1480529192,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3659504255df660cb3cdea2-61016662',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('header')->value;?>

<?php echo $_smarty_tpl->getVariable('menu')->value;?>

<div id="content" class="specialBG">
  <div class="container postDetail">
      <div class="row">
        <div class="box col-xs-12 col-md-10 col-md-offset-1 noPadding">

          <?php if (isset($_smarty_tpl->getVariable('headLine',null,true,false)->value)){?><span class="col-xs-12 headLine"><?php echo $_smarty_tpl->getVariable('headLine')->value;?>
</span><?php }?>
          <?php if ($_smarty_tpl->getVariable('items')->value){?>
                  <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                  <div class="col-xs-12 itemListGroup <?php if ($_smarty_tpl->tpl_vars['k']->value%2==1){?>x2<?php }?> noPadding">
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                    <div class="col-xs-6 col-sm-2 itemList noPadding">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" target="">
                      <div class="item">
                        <div class="image">
                            <img class="lazy" data-original="<?php echo $_smarty_tpl->tpl_vars['i']->value['image'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
">
                            <?php if ($_smarty_tpl->tpl_vars['i']->value['video']){?><div class="videoBox"><div class="playIcon small"></div></div><?php }?>
                        </div>
                        <div class="itemTitle">
                          <h2><?php echo $_smarty_tpl->tpl_vars['i']->value['name_cut'];?>
</h2>
                        </div>
                      </div>
                    </a>
                    </div>
                    <?php }} ?>
                  </div>
                  <?php }} ?>

              <?php if ($_smarty_tpl->getVariable('pagination')->value){?>
              <div class="col-xs-12 post_pagination"><?php echo $_smarty_tpl->getVariable('pagination')->value;?>
</div>
              <?php }?>
          <?php }else{ ?>
          <div class="col-xs-12 resultInfo"><?php if (isset($_smarty_tpl->getVariable('resultInfo',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('resultInfo')->value;?>
<?php }else{ ?>Kategoriye ait kayıt bulunamadı.<?php }?></div>
          <?php }?>

        </div>
      </div>
  </div>
</div>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

