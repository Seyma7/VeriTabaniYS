<?php /* Smarty version Smarty-3.0.8, created on 2019-12-16 00:43:40
         compiled from "C:\wamp64\www/view/post_detail.html" */ ?>
<?php /*%%SmartyHeaderCode:9435062675df6a90ca2d5b3-66372330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd2aa7264a34fd67b4fe6db757db34fd7ed0e6ffd' => 
    array (
      0 => 'C:\\wamp64\\www/view/post_detail.html',
      1 => 1576446219,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9435062675df6a90ca2d5b3-66372330',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('header')->value;?>

<?php echo $_smarty_tpl->getVariable('menu')->value;?>

<div id="content" class="specialBG x2">
  <div class="container postDetail">
      <div class="row">
        <div class="box col-xs-12 col-md-10 col-md-offset-1 noPadding">

          <div class="col-xs-12 col-sm-8 postContent">

            <span class="col-xs-12 headLine"><h1><?php echo $_smarty_tpl->getVariable('post_title')->value;?>
</h1></span>
            <div class="col-xs-12 postImage">
                <?php if (count($_smarty_tpl->getVariable('post_images')->value)==1){?>
                <img class="lazy" src="<?php echo $_smarty_tpl->getVariable('post_images')->value[0]['big'];?>
" data-original="<?php echo $_smarty_tpl->getVariable('post_images')->value[0]['big'];?>
" title="" alt=""> 
                <?php }else{ ?>
                <div class="latestVideos noPadding">
                  <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('post_images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                    <div class="item">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['i']->value['big'];?>
" title="<?php echo $_smarty_tpl->getVariable('post_title')->value;?>
" alt="<?php echo $_smarty_tpl->getVariable('post_title')->value;?>
">
                    </div>
                  <?php }} ?>
                </div>
                <?php }?>
            </div>
            <div class="col-xs-12 postDescription noPadding"><?php echo $_smarty_tpl->getVariable('post_description')->value;?>
</div>

            <?php if ($_smarty_tpl->getVariable('post_video')->value){?>
            <?php if ($_smarty_tpl->getVariable('post_video_name')->value){?><b><h2><?php echo $_smarty_tpl->getVariable('post_video_name')->value;?>
</h2></b><?php }?>
            <div class="col-xs-12 postVideo noPadding">
              <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="<?php echo $_smarty_tpl->getVariable('post_video')->value;?>
"></iframe>
              </div>
            </div>
            <?php }?>

            <div class="col-xs-12 postInfo">
              <?php echo $_smarty_tpl->getVariable('post_date_added')->value;?>
<?php if ($_smarty_tpl->getVariable('post_date_updated')->value){?> (Güncellendi: <?php echo $_smarty_tpl->getVariable('post_date_updated')->value;?>
)<?php }?>
              <div class="col-xs-12 noPadding postAttr">
                <div class="postShare">
                    <span class="head">Haberi paylaş: </span>
                    <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['facebook'];?>
" target="_blank"><i class="fa share fb fa-facebook" aria-hidden="true"></i></a>
                    <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['twitter'];?>
" target="_blank"><i class="fa share t fa-twitter" aria-hidden="true"></i></a>
                    <a href="<?php echo $_smarty_tpl->getVariable('post_share')->value['whatsapp'];?>
"  data-action="share/whatsapp/share"><i class="fa share wp fa-whatsapp" aria-hidden="true"></i></a>
                </div>
                <div class="postRatio">
                    <span class="head">Haberi oyla</span>
                    <i data-ratio="like" data-post="<?php echo $_smarty_tpl->getVariable('post_id')->value;?>
" class="ratioController fa ratio up fa-thumbs-up" aria-hidden="true"></i>
                    <span id="post_like"><?php echo $_smarty_tpl->getVariable('post_like')->value;?>
</span>
                    <i data-ratio="dislike" data-post="<?php echo $_smarty_tpl->getVariable('post_id')->value;?>
" class="ratioController fa ratio down fa-thumbs-down" aria-hidden="true"></i>
                    <span id="post_dislike"><?php echo $_smarty_tpl->getVariable('post_dislike')->value;?>
</span>
                </div>
              </div>
            </div>

          </div>
          <div class="col-xs-12 col-sm-4 mostNews noPadding">
            <?php if ($_smarty_tpl->getVariable('most_read')->value){?>
            <span class="col-xs-12 headLine">EN ÇOK OKUNAN HABERLER</span>
            <div class="col-xs-12 itemSmallGroup noPadding">
              <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('most_read')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
               <div class="col-xs-6 col-sm-12 itemSmall">
                 <a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
">
                   <div class="col-xs-12 item<?php if ($_smarty_tpl->tpl_vars['i']->value%2==1){?> x2<?php }?>">
                     <div class="col-xs-12 col-sm-6 image noPadding">
                        <img class="lazy" src="view/images/dot.png" data-original="<?php echo $_smarty_tpl->tpl_vars['i']->value['image'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
">
                         <?php if ($_smarty_tpl->tpl_vars['i']->value['video']){?><div class="videoBox"><div class="playIcon list"></div></div><?php }?>
                     </div>
                     <div class="col-xs-12 col-sm-6 itemTitle noPadding">
                       <h2><?php echo $_smarty_tpl->tpl_vars['i']->value['name_cut'];?>
</h2>
                     </div>
                   </div>
                 </a>
               </div>
             <?php }} ?>
            </div>
            <?php }?>
          </div>

          <?php if ($_smarty_tpl->getVariable('items')->value){?>
              <span class="col-xs-12 headLine">İLGİLİ HABERLER</span>
              <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
              <div class="col-xs-12 itemListGroup <?php if ($_smarty_tpl->tpl_vars['k']->value%2==0){?>x2<?php }?> noPadding">
                <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                <div class="col-xs-6 col-sm-2 itemList noPadding">
                <a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
">
                  <div class="item">
                    <div class="image">
                        <img class="lazy" src="view/images/dot.png" data-original="<?php echo $_smarty_tpl->tpl_vars['i']->value['image'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
">
                        <?php if ($_smarty_tpl->tpl_vars['i']->value['video']){?><div class="videoBox"><div class="playIcon small"></div></div><?php }?>
                    </div>
                    <div class="itemTitle">
                      <h2><?php echo $_smarty_tpl->tpl_vars['i']->value['name_cut'];?>
</h2>
                    </div>
                  </div>
                </a>
                </div>
                <?php }} ?>
              </div>
              <?php }} ?>
          <?php }?>

  	   </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	var ratio_url 			= "<?php echo $_smarty_tpl->getVariable('ratio_url')->value;?>
";

  
 	$('.ratioController').click(function(){

 		   var dataRatio	  = $(this).attr('data-ratio');
       var dataPost		  =	$(this).attr('data-post');
       var dataRatioNum	=	$(this).attr('data-ratioNum');

 			 $.ajax({
 				url		: ratio_url,
 				type	: 'POST',
 				dataType: 'JSON',
 				data	: 	{
 								post: dataPost,
         				ratio: dataRatio,
 							},
 				success	: function(json) {

  					if(json['success']){

                $( 'span#post_' + dataRatio ).html(json['ratio']);

  					}/*else if(json['error']){

              alert(json['error']);
  					}*/

 				},
 				complete: function () {
 				}
 			});
 	});
  
</script>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

