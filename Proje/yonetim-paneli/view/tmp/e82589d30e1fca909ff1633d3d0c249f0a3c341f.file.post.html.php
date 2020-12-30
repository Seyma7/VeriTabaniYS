<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:29:37
         compiled from "C:\wamp\www\Proje/yonetim-paneli/view/post.html" */ ?>
<?php /*%%SmartyHeaderCode:282655fecd521d92866-46502966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e82589d30e1fca909ff1633d3d0c249f0a3c341f' => 
    array (
      0 => 'C:\\wamp\\www\\Proje/yonetim-paneli/view/post.html',
      1 => 1481374174,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '282655fecd521d92866-46502966',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('header')->value;?>

<?php if (isset($_smarty_tpl->getVariable('error',null,true,false)->value)){?><div class="error_gen marg10"><b>Hata:</b> <?php echo $_smarty_tpl->getVariable('error')->value;?>
</div><?php }?>
<div class="box_head"></div>
<div class="box_body">
	<div class="heading_title"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</div>
	<div class="heading_desc"><?php if (isset($_smarty_tpl->getVariable('description',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('description')->value;?>
<?php }?></div>
		<div class="buttons">
			<div style="margin-bottom:10px;">
				<form id="search" method="get" autocomplete="off">
					<input type="hidden" name="controller" value="<?php if (isset($_smarty_tpl->getVariable('search_action',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('search_action')->value;?>
<?php }else{ ?>post<?php }?>"/>
					<input type="text" name="search_query" value="<?php if (isset($_smarty_tpl->getVariable('search_query',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('search_query')->value;?>
<?php }?>" placeholder="Haber Adı" class="input1"> <a href="javascript:;" onclick="$('form#search').submit();" class="button">Ara</a>
				</form>
			</div>
			<a href="<?php echo $_smarty_tpl->getVariable('insert')->value;?>
" class="button">Ekle</a> <a onClick="$('form#categoryDelete').submit();" class="button">Seçili Haberleri Sil</a>
		</div>

		<?php if (isset($_smarty_tpl->getVariable('preserve',null,true,false)->value)){?>
			<div class="preserve_list">
				<div class="floatLeft">
					<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('preserve')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
						<span><i title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" class="fa fa-thumb-tack preserve <?php echo $_smarty_tpl->tpl_vars['i']->value['code'];?>
" aria-hidden="true"></i> <?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</span>
					<?php }} ?>
				</div>
				<div class="floatRight">
					<i class="fa fa-th-large" aria-hidden="true"></i>
					<select class="offsetData">
						<option value="<?php echo $_smarty_tpl->getVariable('default_preserve_url')->value;?>
">-</option>
						<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('preserve')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['i']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['i']->value['selected']){?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</option>
						<?php }} ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
		<?php }?>

			<?php if ($_smarty_tpl->getVariable('posts')->value){?>
		 <form action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" method="post" autocomplete="off" id="categoryDelete">
			 <table class="list">
				 <tr class="head">
					 <td width="1%" align="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
					 <td width="3%"></td>
					 <td width="20%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['name']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['name']['class'];?>
">Başlık</a></td>
					 <td align="center" width="10%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['sort_order']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['sort_order']['class'];?>
">Sıralama</a></td>
					 <td width="10%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['user_id']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['user_id']['class'];?>
">Ekleyen Kişi</a></td>
					 <td width="10%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['date_added']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['date_added']['class'];?>
">Eklenme Tarihi</a></td>
					 <td width="10%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['last_update_user_id']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['last_update_user_id']['class'];?>
">Güncelleyen</a></td>
					 <td width="10%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['date_updated']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['date_updated']['class'];?>
">Güncellenme Tarihi</a></td>
					 <td width="5%" class="center"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['status']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['status']['class'];?>
">Durumu</a></td>
					 <td width="10%" align="right">İşlem</td>
				 </tr>
				 <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('posts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
				 <tr class="gridrow_">
					 <td align="center"><input type="checkbox" name="selected[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
" /></td>
					 <td><?php if (isset($_smarty_tpl->tpl_vars['i']->value['preserve'])){?> <?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['i']->value['preserve']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
?> <i title="<?php echo $_smarty_tpl->tpl_vars['j']->value['name'];?>
" class="fa fa-thumb-tack preserve <?php echo $_smarty_tpl->tpl_vars['j']->value['code'];?>
" aria-hidden="true"></i> <?php }} ?> <?php }?></td>
					 <td><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</td>
					 <td align="center"><?php echo $_smarty_tpl->tpl_vars['i']->value['sort_order'];?>
</td>
					 <td><?php echo $_smarty_tpl->tpl_vars['i']->value['add_username'];?>
</td>
					 <td><?php echo $_smarty_tpl->tpl_vars['i']->value['date_added'];?>
</td>
					 <td><?php echo $_smarty_tpl->tpl_vars['i']->value['last_update_username'];?>
</td>
					 <td><?php echo $_smarty_tpl->tpl_vars['i']->value['date_updated'];?>
</td>
					 <td align="center"><img src="view/image/<?php if ($_smarty_tpl->tpl_vars['i']->value['status']==1){?>active<?php }else{ ?>passive<?php }?>.png" /></td>
					 <td align="right"> [<a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['edit'];?>
">düzenle</a>]</td>
				 </tr>
				 <?php }} ?>
			 </table>
		 </form>
		 <?php if ($_smarty_tpl->getVariable('pagination')->value){?><div class="pagination"><?php echo $_smarty_tpl->getVariable('pagination')->value;?>
</div><?php }?>
		 <?php }else{ ?>
		 <div class="attention"><b>Uyarı: </b> Kayıtlı haber bulunamadı.</div>
		 <?php }?>
</div>
	<script type="text/javascript">
	$( "select.offsetData" ).change(function() {
			location.href = $(this).val();
	});
</script>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

