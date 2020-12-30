<?php /* Smarty version Smarty-3.0.8, created on 2019-12-16 00:21:09
         compiled from "C:\wamp64\www/view/contact.html" */ ?>
<?php /*%%SmartyHeaderCode:7344417995df6a3c5659b37-79716039%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22b53d107717e1c07aefb1fc399cb3bd298c23fb' => 
    array (
      0 => 'C:\\wamp64\\www/view/contact.html',
      1 => 1481399324,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7344417995df6a3c5659b37-79716039',
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


            <span class="col-xs-12  headLine"><h1>İletişim</h1></span>
            <div class="col-xs-12 pageDescription noPadding">
              <?php if ($_smarty_tpl->getVariable('error')->value){?><div class="alert alert-danger"><?php echo $_smarty_tpl->getVariable('error')->value;?>
</div><?php }?>
              <?php if ($_smarty_tpl->getVariable('success')->value){?><div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
</div><?php }?>
              <div class="col-xs-12 col-sm-10 noPadding">
                <form method="POST">
                  </p>
                    <div class="form-group col-xs-12 col-sm-4 ">
                      <label for="firstname">Adınız*</label>
                      <input type="text" name="firstname" class="form-control"  placeholder="Adınız" id="firstname" value="<?php echo $_smarty_tpl->getVariable('message')->value['firstname'];?>
">
                    </div>
                    <div class="form-group col-xs-12 col-sm-4 ">
                      <label for="lastname">Soyadınız*</label>
                      <input type="text" name="lastname" class="form-control" placeholder="Soyadınız"  id="lastname" value="<?php echo $_smarty_tpl->getVariable('message')->value['lastname'];?>
">
                    </div>
                    <div class="form-group col-xs-12 col-sm-4 ">
                      <label for="email">Eposta Adresiniz*</label>
                      <input type="text" name="email" class="form-control"  placeholder="Eposta Adresiniz" id="email" value="<?php echo $_smarty_tpl->getVariable('message')->value['email'];?>
">
                    </div>
                    <div class="form-group col-xs-12 ">
                      <label for="subject">Konu*</label>
                      <textarea name="subject" class="form-control" placeholder="Konu"  id="subject"><?php echo $_smarty_tpl->getVariable('message')->value['subject'];?>
</textarea>
                    </div>
                    <div class="form-group col-xs-12 ">
                      <div class="col-xs-12 noPadding"><label for="security">Doğrulama Kodu*</label></div>
                      <div class="col-xs-12 noPadding col-sm-4 clearfix visible-xs-block visible-sm-block visible-md-block  visible-lg-block sep10">
                        <div class="captchaImage pull-left"><img id="captchaIMG" src=""></div>
                        <div class="renewCaptcha pull-left"><i class="fa fa-refresh" aria-hidden="true"></i></div>
                      </div>
                      <div class="col-xs-12 noPadding"><input type="text" name="captcha" class="form-control" placeholder="Doğrulama Kodu"  id="security"></div>
                    </div>
                    <div class="col-xs-12"><button type="submit" class="btn btn-primary">Gönder</button></div>
                  </p>
                </form>
              </div>
            </div>

						<div class="col-xs-12 socialMedia">
              <div class="postShare">
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['facebook'];?>
" target="_blank"><i class="fa share fb fa-facebook" aria-hidden="true"></i></a>
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['twitter'];?>
" target="_blank"><i class="fa share t fa-twitter" aria-hidden="true"></i></a>
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['gmail'];?>
" target="_blank"><i class="fa share g fa-google" aria-hidden="true"></i></a>
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['linkedin'];?>
" target="_blank"><i class="fa share in fa-linkedin" aria-hidden="true"></i></a>
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['whatsapp'];?>
"  data-action="share/whatsapp/share"><i class="fa share wp fa-whatsapp" aria-hidden="true"></i></a>
                  <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['pinterest'];?>
" target="_blank"><i class="fa share pin fa-pinterest-p" aria-hidden="true"></i></a>
              </div>
            </div>

  	   </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	var captcha_url 	  = "<?php echo $_smarty_tpl->getVariable('captcha_url')->value;?>
";
	function renew_captcha () { $('img[id="captchaIMG"]').attr('src', captcha_url);	}
  $('.renewCaptcha').click(function(){ renew_captcha(); })
  renew_captcha();
</script>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

