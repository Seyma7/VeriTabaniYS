<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:27:47
         compiled from "C:\wamp\www\Proje/view/menu.html" */ ?>
<?php /*%%SmartyHeaderCode:237235fecd4b34b4336-00577376%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f20eb7fa9958ccf13b10ecf8951488ad18a0f89b' => 
    array (
      0 => 'C:\\wamp\\www\\Proje/view/menu.html',
      1 => 1576357859,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '237235fecd4b34b4336-00577376',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="container-fluid" id="menu">
	<div class="container">
		<div class="row">
	    	<div class="box col-md-10 col-md-offset-1 noPadding">
					<div class="col-md-12 noPadding">
						<div id="mobileNav" class="col-xs-12 hidden-md hidden-lg noPadding">
									<i class="fa bar leftBar fa-bars" data-type="menu" aria-hidden="true"></i>
									<div class="logo"><a href="./" title="Latest News" alt="Latest News"><img  src="view/images/haber.png"/></a></div>
									<i class="fa bar rightBar fa-search" data-type="search" aria-hidden="true"></i>
						</div>
						<ul class="mobileMenu menu nav nav-pills">
							<?php if ($_smarty_tpl->getVariable('menu_category')->value){?>
							<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menu_category')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
							<li class="<?php if (isset($_smarty_tpl->tpl_vars['i']->value['special_menu'])&&$_smarty_tpl->tpl_vars['i']->value['special_menu']){?>special <?php }?><?php if ($_smarty_tpl->tpl_vars['i']->value['active']||$_smarty_tpl->tpl_vars['i']->value['slug']==$_smarty_tpl->getVariable('menu_slug')->value){?>active<?php }?>"><a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</a></li>
							<?php }} ?>
							<?php }?>
							<li class="searchForm pull-right hidden-xs hidden-sm">
								<form action="<?php echo $_smarty_tpl->getVariable('search_url')->value;?>
" method="post">
									<input type="text" name="search" class="searchInput"/>
									<i class="fa searchButton fa-search" aria-hidden="true"></i>
								</form>
							</li>
					 	</ul>
						<ul class="mobileMenu search nav nav-pills  hidden-md hidden-lg"></ul>
					</div>
				</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#mobileNav .bar').click(function(){
			var item  = $(this).attr('data-type');
			$('ul.mobileMenu.show').not("." + item).removeClass('show');
			$('ul.mobileMenu.' + item ).toggleClass('show');
	});

</script>
<script type="text/javascript">
	var menuP = $( "#menu" ).position().top;
	$( window ).on( "ready scroll resize", function() {
			var wWidth = $( window ).width();
	    var scroll = $(window).scrollTop();
	    if( scroll > menuP && wWidth > 992 )
	      $("#menu").addClass("sticky");
	    else
	      $("#menu").removeClass("sticky");
	});
</script>
