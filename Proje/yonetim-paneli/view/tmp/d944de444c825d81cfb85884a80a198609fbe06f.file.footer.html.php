<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:28:47
         compiled from "C:\wamp\www\Proje/yonetim-paneli/view/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:27965fecd4ef880ac7-80565419%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd944de444c825d81cfb85884a80a198609fbe06f' => 
    array (
      0 => 'C:\\wamp\\www\\Proje/yonetim-paneli/view/footer.html',
      1 => 1480369332,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27965fecd4ef880ac7-80565419',
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
