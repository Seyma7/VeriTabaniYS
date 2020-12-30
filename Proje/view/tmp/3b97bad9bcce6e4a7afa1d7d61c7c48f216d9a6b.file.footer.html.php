<?php /* Smarty version Smarty-3.0.8, created on 2019-12-16 01:43:28
         compiled from "C:\wamp64\www/view/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:6971543435df6b7106b9a66-14127363%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b97bad9bcce6e4a7afa1d7d61c7c48f216d9a6b' => 
    array (
      0 => 'C:\\wamp64\\www/view/footer.html',
      1 => 1576449807,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6971543435df6b7106b9a66-14127363',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" href="view/assets/bootstrap/js/bootstrap.min.js">
<div class="container-fluid" id="footer">
	<div class="container ">
		<div class="row">
        <div class="box col-xs-12 col-md-10 col-md-offset-1 noPadding">
		 		<div class="col-xs-12 hidden-xs col-sm-6"></div>
		 		<div class="col-xs-12 col-sm-6 info">
					<div class="col-xs-12 col-sm-6 "></div>
		 			<div class="col-xs-12 col-sm-6 item">
		 				<h2 class="footerMenu" data-type="about"  data-toggle="collapse" data-target="#about">SİTEMİZ HAKKINDA</h2>
		 				<ul id="about"  class="nav nav-pills nav-stacked">
						    <li><a href="<?php echo $_smarty_tpl->getVariable('about_url')->value;?>
">Hakkında</a></li>
						    <li><a href="<?php echo $_smarty_tpl->getVariable('privacy_url')->value;?>
">Hukuki Şartlar & Gizlilik</a></li>
						    <li><a href="<?php echo $_smarty_tpl->getVariable('contact_us_url')->value;?>
">Bize Ulaşın</a></li>
					 	</ul>
						<?php if ($_smarty_tpl->getVariable('social_urls')->value){?>
						<div class="col-xs-12  noPadding socialMedia">
              <div class="postShare">
                  <?php if (isset($_smarty_tpl->getVariable('social_urls',null,true,false)->value['twitter'])){?><a href="<?php echo $_smarty_tpl->getVariable('social_urls')->value['twitter'];?>
" target="_blank"><i class="fa share t fa-twitter" aria-hidden="true"></i></a><?php }?>
                  <?php if (isset($_smarty_tpl->getVariable('social_urls',null,true,false)->value['gmail'])){?><a href="<?php echo $_smarty_tpl->getVariable('social_urls')->value['gmail'];?>
" target="_blank"><i class="fa share g fa-google" aria-hidden="true"></i></a><?php }?>
                  <?php if (isset($_smarty_tpl->getVariable('social_urls',null,true,false)->value['youtube'])){?><a href="<?php echo $_smarty_tpl->getVariable('social_urls')->value['youtube'];?>
" target="_blank"><i class="fa share yt fa-youtube-play" aria-hidden="true"></i></a><?php }?>
                  <?php if (isset($_smarty_tpl->getVariable('social_urls',null,true,false)->value['linkedin'])){?><a href="<?php echo $_smarty_tpl->getVariable('social_urls')->value['linkedin'];?>
" target="_blank"><i class="fa share in fa-linkedin" aria-hidden="true"></i></a><?php }?>
                  <?php if (isset($_smarty_tpl->getVariable('social_urls',null,true,false)->value['pinterest'])){?><a href="<?php echo $_smarty_tpl->getVariable('social_urls')->value['pinterest'];?>
" target="_blank"><i class="fa share pin fa-pinterest-p" aria-hidden="true"></i></a><?php }?>
              </div>
            </div>
						<?php }?>
		 			</div>
		 		</div>

				<div id="footerMenu" class="visible-xs-block hidden-sm hidden-md hidden-lg noPadding"><i id="showFooterParentMenu" class="fa bar leftBar fa-bars" data-type="menu" aria-hidden="true"></i></div>
			</div>
	 	</div>
	</div>
</div>
<script type="text/javascript">
	$('#showFooterParentMenu').click(function(){
		$('#footer .info ').toggleClass('show');
	});
	$('#footer h2.footerMenu').click(function(){
			var item  = $(this).attr('data-type');
			$('#footer .nav.show').not("#" + item).removeClass('show');
			$('#footer #' + item ).toggleClass('show');
	});
</script>
</body>
</html>
