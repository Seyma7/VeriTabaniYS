<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:02:13
         compiled from "C:\wamp64\www\Proje/yonetim-paneli/view/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:216597405fecceb5f1e3c9-95605902%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04c9c39b6eb34bb4ea50cc6aae9458343dc7f501' => 
    array (
      0 => 'C:\\wamp64\\www\\Proje/yonetim-paneli/view/footer.html',
      1 => 1480369332,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '216597405fecceb5f1e3c9-95605902',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('isLogged')->value){?>
<div id="footer"><?php echo @SYSTEM_NAME;?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('tr.gridrow_').mouseenter(function(){$(this).addClass('gridrowover')}).mouseleave(function(){$(this).removeClass('gridrowover')});
});
</script>
<?php }?>

<script type="text/javascript" src="view/js/jquery.stringLengthValidation.js"></script>  
</body>
</html>
