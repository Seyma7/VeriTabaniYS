<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:28:47
         compiled from "C:\wamp\www\Proje/yonetim-paneli/view/login.html" */ ?>
<?php /*%%SmartyHeaderCode:160535fecd4ef9043e4-80022271%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd8f21a4e8042576862a50edb7eb975e794efa49d' => 
    array (
      0 => 'C:\\wamp\\www\\Proje/yonetim-paneli/view/login.html',
      1 => 1576411810,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160535fecd4ef9043e4-80022271',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('header')->value;?>

<div id="login">
    <div style="width: 100%;height: 94px;background: url(view/image/logo.png) no-repeat center; margin-bottom:10px;"></div>
    <?php if (isset($_smarty_tpl->getVariable('error',null,true,false)->value)){?>
    <div id="login_error" style="margin-bottom: 0px;"><b>Hata:</b> <?php echo $_smarty_tpl->getVariable('error')->value;?>
</div>
    <?php }?>
    <form action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" method="post" autocomplete="off" id="loginForm" style="margin-top: 10px;"><p><label>Kullanıcı
        adı<br/> <input type="text" name="username" id="user_login" class="input" value="" size="20"
                        tabindex="10"/></label></p>
        <p><label>Parola<br/> <input type="password" name="password" id="user_pass" class="input" value="" size="20"
                                     tabindex="20"/></label></p>  <p class="submit"> <?php if (isset($_smarty_tpl->getVariable('redirect',null,true,false)->value)){?><input type="hidden" name="redirect" value="view/ekle.php"/><?php }?> <a
                    onClick="$('form#loginForm').submit()" class="button">Giriş</a></p></form>
    <script type="text/javascript">    var captcha_url = "<?php echo $_smarty_tpl->getVariable('captcha_url')->value;?>
";

    function renew_captcha() {
        $('img[id="captchaIMG"]').attr('src', captcha_url);
    }

    $('.renewCaptcha').click(function () {
        renew_captcha();
    })
    renew_captcha();

    function pisilab_form_focus() {
        setTimeout(function () {
            try {
                d = document.getElementById('user_login');
                d.focus();
                d.select();
            } catch (e) {
            }
        }, 200);
    }

    pisilab_form_focus();
    $('input[name="username"]').keydown(function (e) {
        if (e.keyCode == 13) {
            $('input[name="password"]').focus();
        }
    });
    $('input[name="password"]').keydown(function (e) {
        if (e.keyCode == 13) {
            $('#loginForm').submit();
        }
    });    </script>
    <p id="pisitext"><?php echo @SYSTEM_NAME;?>
</p></div><?php echo $_smarty_tpl->getVariable('footer')->value;?>
