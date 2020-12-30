<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:29:35
         compiled from "C:\wamp\www\Proje/yonetim-paneli/view/category.html" */ ?>
<?php /*%%SmartyHeaderCode:63845fecd51f466d23-85702285%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c537d3c782f94879b80bf5e77a181f26d0c6a63' => 
    array (
      0 => 'C:\\wamp\\www\\Proje/yonetim-paneli/view/category.html',
      1 => 1480637952,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63845fecd51f466d23-85702285',
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
<?php if ($_smarty_tpl->getVariable('current_category_path')->value){?> : <?php echo $_smarty_tpl->getVariable('current_category_path')->value;?>
<?php }?></div>
	<div class="heading_desc">Haber kategorisi ekleyebilir, varolanları düzeltip silebilirsiniz. Sistem sınırsız kategori hiyerarşisine sahiptir. Yeni bir kategori eklemek için aşağıdaki <i>Yeni Kategori Ekle</i> butonunu tıklayınız.</div>
	<div class="buttons">
		<div style="margin-bottom:10px;">
			<form id="search" method="get" autocomplete="off">
				<input type="hidden" name="controller" value="category"/>
				<?php if (isset($_smarty_tpl->getVariable('parent',null,true,false)->value)){?>
					<input type="hidden" name="parent" value="<?php echo $_smarty_tpl->getVariable('parent')->value;?>
"/>
				<?php }?>
				<input type="text" name="search_query" value="<?php if (isset($_smarty_tpl->getVariable('search_query',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('search_query')->value;?>
<?php }?>" placeholder="Kategori Adı" class="input1"> <a href="javascript:;" onclick="$('form#search').submit();" class="button">Ara</a>
			</form>
		</div>
		<a href="<?php echo $_smarty_tpl->getVariable('insert')->value;?>
" class="button">Yeni Kategori Ekle</a> <a onClick="$('form#categoryDelete').submit();" class="button">Seçili Kategorileri Sil</a>
	</div>
	<?php if ($_smarty_tpl->getVariable('categories')->value){?>
	<form action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" method="post" autocomplete="off" id="categoryDelete">
		<table class="list">
			<tr class="head">
				<td width="1%" align="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
				<td width="2%"></td>
				<td width="19%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['name']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['name']['class'];?>
">Kategori Adı</a></td>
				<td width="20%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['page_title']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['page_title']['class'];?>
">Kategori Sayfa Başlığı</a></td>
				<td align="center" width="10%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['sort_order']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['sort_order']['class'];?>
">Sıralama</a></td>
				<td width="15%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['date_added']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['date_added']['class'];?>
">Eklenme Tarihi</a></td>
				<td width="15%"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['date_updated']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['date_updated']['class'];?>
">Güncellenme Tarihi</a></td>
				<td width="5%" class="center"><a href="<?php echo $_smarty_tpl->getVariable('link')->value['status']['url'];?>
" class="<?php echo $_smarty_tpl->getVariable('link')->value['status']['class'];?>
">Durumu</a></td>
				<td width="10%" align="right">İşlem</td>
			</tr>
			<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categories')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
			<tr class="gridrow_">
				<td align="center"><input type="checkbox" name="selected[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
" /></td>
				<td width="2%"><a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['url'];?>
"><img src="view/image/folder.png" /></a></td>
				<td><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['i']->value['page_title'];?>
</td>
				<td align="center"><?php echo $_smarty_tpl->tpl_vars['i']->value['sort_order'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['i']->value['date_added'];?>
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
	<div class="attention"><b>Uyarı: </b> Kayıtlı kategori bulunamadı.</div>
	<?php }?>
</div>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

