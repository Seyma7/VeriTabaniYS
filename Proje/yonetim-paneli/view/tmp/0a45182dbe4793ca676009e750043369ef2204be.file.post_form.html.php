<?php /* Smarty version Smarty-3.0.8, created on 2020-12-30 22:33:56
         compiled from "C:\wamp\www\Proje/yonetim-paneli/view/post_form.html" */ ?>
<?php /*%%SmartyHeaderCode:31955fecd6245e74f6-17589300%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a45182dbe4793ca676009e750043369ef2204be' => 
    array (
      0 => 'C:\\wamp\\www\\Proje/yonetim-paneli/view/post_form.html',
      1 => 1481374912,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31955fecd6245e74f6-17589300',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php echo $_smarty_tpl->getVariable('header')->value;?>

<?php if (isset($_smarty_tpl->getVariable('error',null,true,false)->value)){?><div class="error_gen marg10"><b>Hata:</b> <?php echo $_smarty_tpl->getVariable('error')->value;?>
</div><?php }?>
<script type="text/javascript" src="view/js/jquery-ui-1.8.23.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="view/css/flick/jquery-ui-1.8.23.custom.css" />
<script type="text/javascript" src="view/js/ajaxupload.js"></script>
<script src="view/js/ckeditor/ckeditor.js"></script>
<div class="box_head"></div>
<div class="box_body">
	<div class="heading_title"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</div>
	<div class="buttons marg10">
		<a onClick="$('form#save').submit();" class="button">Kaydet</a>
		<a href="<?php echo $_smarty_tpl->getVariable('cancel')->value;?>
" class="button">Vazgeç</a>
		<?php if ($_smarty_tpl->getVariable('delete')->value){?>
		<a href="<?php echo $_smarty_tpl->getVariable('delete')->value;?>
" class="button">Kayıt Sil</a>
		<?php }?>
		<span class="quick">Hızlı işlem:
			<select name="" onChange="$('#stayOnPage').val($(this).val()); $('form#save').submit();" class="input1" style="width: 200px">
				<option value="0">Bir işlem seçin</option>
				<option value="new">Kaydet & Yeni Ekle</option>
				<option value="edit">Kaydet & Sayfada Kal</option>
			</select>
		</span>
	</div>
	<form action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" method="post" autocomplete="off" id="save" name="save">
		<input type="hidden" name="stayOnPage" id="stayOnPage" value="0" />
		<input type="hidden" name="video[status]" value="<?php if (isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])){?><?php echo $_smarty_tpl->getVariable('video')->value['status'];?>
<?php }else{ ?>0<?php }?>"/>
		<div id="tabs" class="htabs">
			<a href="#tab_general">Kategori Bilgileri</a>
			<a href="#tab_description">Haber Bilgileri</a>
			<a href="#tab_property">Haber Özellik</a>
			<a href="#tab_video">Habere Video Ekle</a>
			<a href="#tab_fotograf">Haber Görseli Ekle</a>
		</div>

		<div id="tab_general">
			<table class="list">
				<tr class="head">
					<td width="5">&nbsp;</td>
					<td colspan="2">Haber Kategorisi</td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><span class="required">*</span> Kategori Seçin:</td>
					<td>
						<div id="select_menus">
							<?php if ($_smarty_tpl->getVariable('categories')->value){?>
								<?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categories')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
?>
									<?php if ($_smarty_tpl->tpl_vars['j']->value){?>
										<select name="category" class="select_menu" size="12">
											<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['j']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
												<option  <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
?><?php if ($_smarty_tpl->tpl_vars['c']->value['id']==$_smarty_tpl->tpl_vars['i']->value['id']){?>selected<?php }?><?php }} ?> value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</option>
											<?php }} ?>
										</select>
									<?php }?>
								<?php }} ?>
							<?php }?>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<div id="tab_description">
			<table class="list">
				<tr class="head">
					<td width="5">&nbsp;</td>
					<td colspan="2">Haber Bilgileri</td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><span class="required">*</span> Haber Lokasyon:</td>
					<td>
						<select name="location" class="input1">
						<option value="0">Seçiniz</option>
						<?php if ($_smarty_tpl->getVariable('location_list')->value){?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('location_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
"<?php if ($_smarty_tpl->getVariable('location')->value==$_smarty_tpl->tpl_vars['i']->value['id']){?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</option><?php }} ?><?php }?>
						</select>
          </td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><span class="required">*</span> Başlık:</td>
					<td><input type="text" name="name" value="<?php echo $_smarty_tpl->getVariable('name')->value;?>
" class="input1 stringCounter" maxL="100" minL="10"/></td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><span class="required">*</span> İçerik:</td>
					<td><textarea class="ckeditor" name="description" id="description" class="input1" style="font-size: 11px;" rows="5"><?php echo $_smarty_tpl->getVariable('description')->value;?>
</textarea></td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1">Sıra:</td>
					<td><input type="text" name="sort_order" value="<?php echo $_smarty_tpl->getVariable('sort_order')->value;?>
" class="input1" /></td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1">Yayınlanma Durumu:</td>
					<td>
						<select name="status" class="input1">
						<option value="0">Seçiniz</option>
						<?php if ($_smarty_tpl->getVariable('statuses')->value){?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('statuses')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
"<?php if ($_smarty_tpl->getVariable('status')->value==$_smarty_tpl->tpl_vars['i']->value['id']){?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</option><?php }} ?><?php }?>
						</select>
					</td>
				</tr>
			</table>
		</div>

    <div id="tab_property">
			<table class="list">
				<tr class="head">
					<td width="5">&nbsp;</td>
					<td colspan="2">Haber Özellik</td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1">Habere Özellik Ekleyin:</td>
					<td>
						 <?php if ($_smarty_tpl->getVariable('preserves')->value){?>
                <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('preserves')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
                <p>
                  <label><input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['i']->value['selected']||($_smarty_tpl->tpl_vars['i']->value['code']=='home'&&$_smarty_tpl->getVariable('method')->value=='insert')){?> checked <?php }?>  name="preserve[][preserve_id]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
"/> <?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['i']->value['description'];?>
)</label>
                </p>
                <?php }} ?>
             <?php }?>
					</td>
				</tr>
			</table>
		</div>

		<div id="tab_video">
			<table class="list">
				<tr class="head">
					<td width="5">&nbsp;</td>
					<td colspan="2">Video Bilgileri (İsteğe Bağlı)</td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><a href="javascript::" id="addVideo" class="button"> <?php if (!isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])||$_smarty_tpl->getVariable('video')->value['status']==0){?>Video Ekle<?php }else{ ?>İptal Et<?php }?></a></td>
					<td>
					</td>
				</tr>
				<tr class="gridrow upVideo"  <?php if (!isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])||$_smarty_tpl->getVariable('video')->value['status']==0){?>style='display:none;'<?php }?>>
					<td></td>
					<td class="field1"><span class="required">*</span> Video Kaynağı:</td>
					<td>
						<select name="video[source]" class="input1">
							<option  value="0">Seçiniz</option>
							<?php if ($_smarty_tpl->getVariable('video_list')->value){?>
								<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('video_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
									<option <?php if (isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])&&$_smarty_tpl->getVariable('video')->value['source']==$_smarty_tpl->tpl_vars['i']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</option>
								<?php }} ?>
							<?php }?>
						</select>
					</td>
				</tr>
				<tr class="gridrow upVideo"  <?php if (!isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])||$_smarty_tpl->getVariable('video')->value['status']==0){?>style='display:none;'<?php }?>>
					<td></td>
					<td class="field1">Video Başlığı (İsteğe Bağlı):</td>
					<td><input type="text" name="video[name]" value="<?php if (isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])){?><?php echo $_smarty_tpl->getVariable('video')->value['name'];?>
<?php }?>" class="input1" /></td>
				</tr>
				<tr class="gridrow upVideo"  <?php if (!isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])||$_smarty_tpl->getVariable('video')->value['status']==0){?>style='display:none;'<?php }?>>
					<td></td>
					<td class="field1"><span class="required">*</span> Video URL Bilgisi:</td>
					<td><input type="text" name="video[url]" value="<?php if (isset($_smarty_tpl->getVariable('video',null,true,false)->value['status'])){?><?php echo $_smarty_tpl->getVariable('video')->value['url'];?>
<?php }?>" class="input1" /></td>
				</tr>
			</table>
		</div>

		<div id="tab_fotograf">
			<table class="list">
				<tr class="head">
					<td width="5">&nbsp;</td>
					<td colspan="2">Resim Yükle</td>
				</tr>
				<tr class="gridrow">
					<td></td>
					<td class="field1"><span class="required">*</span> Haber Resim (en az 1 adet):</td>
					<td>
						<div id="fotograf-center">
							<div id="fotograf-upload"></div>
							<div id="fotograf-upload-loading"></div>
							<div id="status"></div>
							<div class="clear"></div>
							<div id="upload-img">
								<?php if ($_smarty_tpl->getVariable('images')->value){?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
?>
								<label>
									<div id="img-browse">
										<div class="img">
											<img src="<?php echo $_smarty_tpl->tpl_vars['i']->value['preview'];?>
" />
										</div>
										<input name="current_image" type="radio" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['image'];?>
" />
										<input name="image[]" item="0" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['image'];?>
" />
									</div>
								</label>
								<?php }} ?><?php }?>
								<input type="hidden" name="image_selected" value="" />
							</div>
							<div class="clear"></div>
							<div id="img-edit" style="display: <?php if ($_smarty_tpl->getVariable('images')->value){?>block<?php }else{ ?>none<?php }?>;">
								<div class="secili-resim">Seçili olan resmi: </div>
								<div class="ana-resim-yap"><input name="" onClick="doMainImage();" type="button" /></div>
								<div class="resmi-sil"><input name="" onClick="deleteImage();" type="button" /></div>
								<div class="geriye-tasi"><input name="" onClick="imagePrev()" type="button" /></div>
								<div class="ileriye-tasi"><input name="" onClick="imageNext()" type="button" /></div>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<div class="clear"></div>
	</form>
</div>

    <script type="text/javascript">
		
			CKEDITOR.replace('description',{
				filebrowserBrowseUrl: 'view/js/browser/browse.php',
				filebrowserImageBrowseUrl: 'view/js/browser/browse.php?type=Images',
				filebrowserUploadUrl: 'view/js/uploader/upload.php',
				filebrowserImageUploadUrl: 'view/js/uploader/upload.php?type=Images',
				filebrowserWindowWidth: '50',
				filebrowserWindowHeight: '50',
				filebrowserBrowseUrl: 'view/js/ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl: 'view/js/ckfinder/ckfinder.html?Type=Images',
				filebrowserFlashBrowseUrl: 'view/js/ckfinder/ckfinder.html?Type=Flash',
				filebrowserUploadUrl: 'view/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl: 'view/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				filebrowserFlashUploadUrl: 'view/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			});
		
    </script>
<script type="text/javascript">
$(window).load(function(){
	$('#tabs a').tabs();
});

$('#addVideo').live('click', function(){
	var upVideoStatus	=	parseInt($("input[name='video[status]']").val());

	if( upVideoStatus == 1 || upVideoStatus == 0 ){
		$('.upVideo').toggle();
		if(upVideoStatus == 1){
			$('#addVideo').html("Video Ekle");
			$("input[name='video[status]']").attr('value',0);
		}else{
			$('#addVideo').html("İptal Et");
			$("input[name='video[status]']").attr('value',1);
		}
	}
});


function doMainImage () {
	$('input[name="image_selected"]').val($('input[name="current_image"]:checked').val());
}

function deleteImage () {
	$('input[name="current_image"]:checked').parent().parent().remove();
}

function imageNext () {
	var selected_item 	= $('input[name="current_image"]:checked').parent().parent();
	var next_item 		= $(selected_item).next();

	if ( $(next_item) ) {

		$(next_item).after($(selected_item));

	}
}


function imagePrev () {
	var selected_item 	= $('input[name="current_image"]:checked').parent().parent();
	var prev_item 		= $(selected_item).prev();

	if ( $(prev_item) ) {

		$(prev_item).before($(selected_item));

	}
}

new AjaxUpload('#fotograf-upload', {
	action: '<?php echo $_smarty_tpl->getVariable('upload_image_url')->value;?>
',
	name: 'image',
	autoSubmit: false,
	responseType: 'json',
	onChange: function(file, extension) {

		if ( $('input[name="image[]"]').length < 10 ) {

			 this.submit();

		} else {

			alert('Toplam 10 adet resim yükleyebilirsiniz.');

		}

	},
	onSubmit: function(file, extension) {

		$('#fotograf-upload').hide();
		$('#fotograf-upload-loading').show();

	},
	onComplete: function(file, json) {

		$('#fotograf-upload-loading').hide();
		$('#fotograf-upload').show();

		if ( json.error ) {

			alert(json.error);

		}

		if ( json.image && json.preview ) {

			$('#img-edit').css('display', 'block');

			$('#upload-img').append('<label><div id="img-browse"><div class="img"><img src="' + json.preview + '" /></div><input name="current_image" type="radio" value="' + json.image + '" /><input name="image[]" type="hidden" item="1" value="' + json.image + '" /></div></label>');

		}

	}
});
</script>


<script type="text/javascript">

$('#select_menus select').live('change', function(){

	var select = $(this);

	$.ajax({
		type		: "POST",
		url			: '<?php echo $_smarty_tpl->getVariable('categories_url')->value;?>
',
		dataType	: 'JSON',
		data		: 'parent_id=' + $(select).val(),
		beforeSend	: function () {

			$('#select_menus select').attr('disabled', 'disabled');

			$.each ( $('#select_menus select'), function(k, v) {

				if ( k > $(select).index() ) {

					$(v).remove();

				}

			});

		},
		success		: function (j) {

			$('#selected_category').html(j.path);

			if(j.status == 1){

				var html = '<select name="category" class="select_menu" size="12">';

				if(j.data){

					$.each(j.data, function(v, k){

						html += '<option value="' + k.id + '">' + k.name + '</option>';

					});

				}

				html += '</select>';

				$('#select_menus').append(html);

			}

			$('#select_menus select').removeAttr('disabled');

		},
		error		: function () {
			return;
		}
	});
});
</script>
<?php echo $_smarty_tpl->getVariable('footer')->value;?>

