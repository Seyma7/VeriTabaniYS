<?php /* Smarty version Smarty-3.0.8, created on 2019-12-15 20:06:33
         compiled from "C:\wamp64\www/yonetim-paneli/view/header.html" */ ?>
<?php /*%%SmartyHeaderCode:20744701285df66819b19b28-44810636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '75b541d2cd927047854c3e2b90ce84bfd2ec087d' => 
    array (
      0 => 'C:\\wamp64\\www/yonetim-paneli/view/header.html',
      1 => 1576326274,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20744701285df66819b19b28-44810636',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="tr-TR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php if (isset($_smarty_tpl->getVariable('title',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('title')->value;?>
 - <?php }?><?php echo @SYSTEM_NAME;?>
</title>
	<meta name='robots' content='noindex,nofollow' />
	<base href="<?php echo $_smarty_tpl->getVariable('base')->value;?>
">
	<link rel="stylesheet" href='view/js/font-awesome/css/font-awesome.min.css' type='text/css' />
	<link rel="stylesheet" href='view/css/style.css?v=2' type='text/css' />
	<script type="text/javascript" src="view/js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="view/js/superfish/js/superfish.js"></script>
	<script type="text/javascript" src="view/js/tabs.js"></script>
</head>
<body>
<?php if ($_smarty_tpl->getVariable('isLogged')->value){?>
<div id="header">
	<div class="div1">
		<div style="float: left"><a href="./"><img src="view/image/haber.png" style="cursor: pointer;" /></a></div>
		<div class="textmenu">
			<div class="MenuText">
				<a href="./" class="MenuText" title="Anasayfaya dön">Anasayfa</a>|
				<a href="<?php echo $_smarty_tpl->getVariable('logout_url')->value;?>
" class="MenuText">Güvenli Çıkış</a>
				<div class="loggedinas"><img src="view/image/lock.png" alt="" style="position: relative; top: 3px;" /> <?php echo $_smarty_tpl->getVariable('login_username')->value;?>
 olarak giriş yaptınız | Sistem saati: <?php echo $_smarty_tpl->getVariable('system_time')->value;?>
</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="div2">
		<div id="menu">
			<ul class="left">
				<li class="_parent"><a href="./" class="top"><span><img src="view/image/home.png" /></span> Anasayfa</a></li>
				<li class="_parent"><a class="top"><span><img src="view/image/category.png" /></span> Kategoriler</a>
					<ul>
						<li><a href="<?php echo $_smarty_tpl->getVariable('category_post_url')->value;?>
"><span><img src="view/image/review.png" /></span> İnternet Gazetesi</a></li>
					</ul>
				</li>
				<li class="_parent"><a class="top"><span><img src="view/image/review.png" /></span> Haber / Yayın</a>
					<ul>
						<li><a href="<?php echo $_smarty_tpl->getVariable('post_url')->value;?>
"><span><img src="view/image/review.png" /></span> İnternet Gazetesi</a></li> 
						<li><a href="<?php echo $_smarty_tpl->getVariable('post_video_url')->value;?>
"><span><img src="view/image/review.png" /></span> Multimedya - Video</a></li>
					</ul>
				</li>
				<li class="_parent"><a href="<?php echo $_smarty_tpl->getVariable('user_url')->value;?>
" class="top"><span><img src="view/image/customer.png" /></span> Hesap</a></li>
				<li class="_parent"><a href="<?php echo $_smarty_tpl->getVariable('editor_url')->value;?>
" class="top"><span><img src="view/image/customer.png" /></span> Editör</a></li>
				<li class="_parent"><a class="top"><span><img src="view/image/product.png" /></span> Sistem</a>
					<ul>
						<li><a href="<?php echo $_smarty_tpl->getVariable('setting_url')->value;?>
"><span><img src="view/image/setting.png" /></span> Ayarlar</a></li>
						<li><a href="<?php echo $_smarty_tpl->getVariable('cache_url')->value;?>
"><span><img src="view/image/log.png" /></span> Cache</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript">

$(document).ready(function() {
	$('#menu > ul').superfish({
		hoverClass	 : 'sfHover',
		pathClass	 : 'overideThisToUse',
		delay		 : 0,
		animation	 : {height: 'show'},
		speed		 : 'normal',
		autoArrows   : false,
		dropShadows  : false,
		disableHI	 : false, /* set to true to disable hoverIntent detection */
		onInit		 : function(){},
		onBeforeShow : function(){},
		onShow		 : function(){},
		onHide		 : function(){}
	});
	$('#menu > ul').css('display', 'block');

	$('form[id*=\'Delete\']').submit(function(){
		if (!confirm("Seçilen kayıtlar silinecek. Emin misiniz? Bu işlem geri alınamaz. Silmek istediğiniz kayıtlar şunları etkileyebilir;\n\n- Bağlantılı alt kategorideki veriler\n- Kayıtlara bağlı tüm özellik ve ayrıcalıklar\n- Görsel ve medya dosyaları")) {
			return false;
		}
	});

	$('form[id*=\'delete\']').submit(function(){
		if (!confirm("Seçilen kayıtlar silinecek. Emin misiniz? Bu işlem geri alınamaz.")) {
			return false;
		}
	});
});


</script>
<div id="content">
<?php if (isset($_smarty_tpl->getVariable('success',null,true,false)->value)){?>
<div class="success marg10"><b>Tamamlandı:</b> <?php echo $_smarty_tpl->getVariable('success')->value;?>
</div>
<?php }?>
<?php }?>
