<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:33:39
         compiled from "C:\wamp\www\Proje/yonetim-paneli/view/user_form.html" */ ?>
<?php /*%%SmartyHeaderCode:270965fecd613499e37-11252099%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '70c910d532b734c4225f3f9c0c1bb9a0dbe918b6' => 
    array (
      0 => 'C:\\wamp\\www\\Proje/yonetim-paneli/view/user_form.html',
      1 => 1480368000,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '270965fecd613499e37-11252099',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php echo $_smarty_tpl->getVariable('header')->value;?>

<?php if (isset($_smarty_tpl->getVariable('error',null,true,false)->value)){?><div class="error_gen marg10"><b>Hata:</b> <?php echo $_smarty_tpl->getVariable('error')->value;?>
</div><?php }?>
<script type="text/javascript" src="view/js/jquery-ui-1.8.23.custom.min.js"></script>
<div class="box_head"></div>
<div class="box_body">
	<div class="heading_title"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</div>
	<div class="heading_desc"><?php if (isset($_smarty_tpl->getVariable('description',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('description')->value;?>
<?php }?></div>
	<div class="buttons marg10">
		<a onClick="$('form#save').submit();" class="button">Kaydet</a>
		<a href="<?php echo $_smarty_tpl->getVariable('cancel')->value;?>
" class="button">Vazgeç</a>
	</div>
	<form action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" method="post" autocomplete="off" id="save" name="save">
		<input type="hidden" name="stayOnPage" id="stayOnPage" value="0" />
		<input type="hidden" name="video[status]" value="<?php if (isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])){?><?php echo $_smarty_tpl->getVariable('video')->value['status'];?>
<?php }else{ ?>0<?php }?>"/>
		<div id="tabs" class="htabs">
			<a href="#tab_general">Hesap Bilgileri</a>
		</div>

		<div id="tab_general">
			<table class="list">
				<tr class="head">
					<td width="5">&nbsp;</td>
					<td colspan="2">Hesap</td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><span class="required">*</span> Parola:</td>
					<td><input type="password" name="oldPassword" value="<?php echo $_smarty_tpl->getVariable('oldPassword')->value;?>
" class="input1" maxlength="20"/></td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><span class="required">*</span> Yeni Parola:</td>
					<td><input type="text" name="password" value="<?php echo $_smarty_tpl->getVariable('password')->value;?>
" class="input1 stringCounter" maxL="20" minL="6" maxlength="20" placeholder="(en az 6 en fazla 20 karakter)"/></td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><span class="required">*</span> Yeni Parola (Tekrar):</td>
					<td><input type="text" name="rePassword" value="<?php echo $_smarty_tpl->getVariable('rePassword')->value;?>
" class="input1 stringCounter" maxL="20" minL="6" maxlength="20" placeholder="(en az 6 en fazla 20 karakter)" /></td>
				</tr>
			</table>
		</div>
		<div class="clear"></div>
	</form>
</div>
<script type="text/javascript">

$('form#save').submit(function(){



});

$(window).load(function(){
	$('#tabs a').tabs();
});
</script>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

