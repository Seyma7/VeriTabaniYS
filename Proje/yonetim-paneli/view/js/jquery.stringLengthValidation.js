
$( ".stringCounter" ).keyup(function() {
  // Max Değeri Çek
  var attrMax = $(this).attr('maxL');
  var max 		= 100;
  if (typeof attrMax !== typeof undefined && attrMax !== false) {
      maxL = parseInt($(this).attr('maxL'));
      max  = (maxL > 0 ? maxL : max);
  }

  // Min Değeri Çek
  var attrMin = $(this).attr('minL');
  var min 		= 3;
  if (typeof attrMin !== typeof undefined && attrMin !== false) {
      minL = parseInt($(this).attr('minL'));
      min  = (minL >= 0 ? minL : min);
  }

  if ( !$( this ).next().is( "span" ) ) {
    $( this ).after( "<span class='stringCounterShowText'></span>" );
  }

  var len = $(this).val().length;
  if(len <= max){ // String boyutunu belirle
    $( this ).next("span.stringCounterShowText").text((max-len));
  }else{ // Fazla string var ise sil.
    $( this ).next("span.stringCounterShowText").text("0");
    $( this ).val( $(this).val().substring(0, max) );
  }

  if(len > 0 && len < min){
    $( this ).addClass("required");
  }else{
    $( this ).removeClass("required");
  }

});
