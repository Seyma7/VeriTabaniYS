<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:33:13
         compiled from "C:\wamp\www\Proje/view/contact_us.html" */ ?>
<?php /*%%SmartyHeaderCode:62795fecd5f9655df8-52338778%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78d482ddfba6ba3ab3ae787b9bc57f5f9efd4c13' => 
    array (
      0 => 'C:\\wamp\\www\\Proje/view/contact_us.html',
      1 => 1576446012,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '62795fecd5f9655df8-52338778',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('header')->value;?>

<?php echo $_smarty_tpl->getVariable('menu')->value;?>

<div id="content" class="specialBG">
  <div class="container content">
      <div class="row">
        <div class="box col-xs-12 col-md-10 col-md-offset-1 noPadding">


            <span class="col-xs-12 headLine"><h1>Bize Ulaşın</h1></span>
            <div class="col-xs-12 pageDescription noPadding">

              <p>
                <b>E-posta Adresimiz</b></br> test@test.com
              </p>
              <p>
                <b>Yazışma adresimiz</b></br>Sakarya / Türkiye
              </p>
              <p>
                <b>Telefon numaramız</b></br>+90 541 972 06 84
              </p>
              <p>
                <b>İçerik Sağlayıcı</b></br>Mahsun Akay & AKG
              </p>

            </div>

						<div class="col-xs-12 noPadding socialMedia">
              <div class="postShare">
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['twitter'];?>
" target="_blank"><i class="fa share t fa-twitter" aria-hidden="true"></i></a>
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['gmail'];?>
" target="_blank"><i class="fa share g fa-google" aria-hidden="true"></i></a>
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['linkedin'];?>
" target="_blank"><i class="fa share in fa-linkedin" aria-hidden="true"></i></a>
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['whatsapp'];?>
"  data-action="share/whatsapp/share"><i class="fa share wp fa-whatsapp" aria-hidden="true"></i></a>
              </div>
            </div>

  	   </div>
    </div>
  </div>
</div>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

