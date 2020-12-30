<?php /* Smarty version Smarty-3.0.8, created on 2019-12-15 20:06:34
         compiled from "C:\wamp64\www/yonetim-paneli/view/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:17390902645df6681a123a88-84712098%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '040bbc993201f105bca1a496bdbd2ca0c3037a7a' => 
    array (
      0 => 'C:\\wamp64\\www/yonetim-paneli/view/footer.html',
      1 => 1480369332,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17390902645df6681a123a88-84712098',
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
