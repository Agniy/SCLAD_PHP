var showSuccess = function(input_el)
{
$(input_el).css('background-color','#BFFFDF');
$(input_el).attr("value","1");

}

var refresh_cart = function(event)
{
    $.ajax({
        url:'/ajax/refresh_basket.php?AJAX=1',
        success: function(data){
           $('#private-area').html(data);
        }
    });
    
}

var delay_tov= function(event)
{
    //alert('123');
    event.preventDefault();
    var parent_tr = $($(event.target).parents("tr"));
    var input_el = $(parent_tr).find('input');

    
    var quant_name = $(input_el).attr('name');
    var quant_val = $(input_el).attr('value');

    var href_tov = $(event.target).attr('href');
    var name_delay = $(event.target).attr('name');
    
    if($(event.target).hasClass('vost'))
        {
         var action='otl';   
         var val_delay='N';
     }
    else if($(event.target).hasClass('delay'))
        {
         var action='otl';
         var val_delay='Y';}
    else if($(event.target).hasClass('del'))
        {
         var action='del';
         var val_delay='Y';
        }
    
    //console.log(action);
    //console.log(val_delay);
    
    if(action=='otl')
    {
      var value_data=quant_name+'='+quant_val+'&'+name_delay+'='+val_delay+'&BasketRefresh=pereschet&AJAX=1';
    }
    else if(action=='del')
    {
      var value_data=name_delay+'='+val_delay+'&BasketRefresh=pereschet&AJAX=1&action='+name_delay;
    }

        $.ajax
        ({
            type: "POST",
            url:href_tov,
            data: value_data,
            beforeSend:function(){
                 //$(event.target).after('<span id="gif_load_buy"><img src="/images/snake-loader.gif" border="0"></span>');
                },
                //quant_name+'='+quant_val+'&'+name_delay+'=Y&BasketRefresh=pereschet&AJAX=1',
            success: function(data){
                //console.log(data);

                //$(input_el).css('background-color','#BFFFDF');
                //$(input_el).attr("value","1");

                $('#wrap_cart').html(data);

                //$("span#gif_load_buy").remove();
                refresh_cart();
            }
        });
    
    //console.log(input_el);
    //console.log(href_tov);
}


var handlerOneTov = function(event)
{
 event.preventDefault();
 
 var parent_input = $($(event.target).parents("div.item-info"));
 var input_el = $($(event.target).parents("div.item-info")).find('.count');
 
 if(input_el.length==0)
     {
     var parent_input = $($(event.target).parents("div.book-price"));
     var input_el = $($(event.target).parents("div.book-price")).find('.count');
     }
 if(input_el.length==0)
     {
     var parent_input = $($(event.target).parents("div.box-price"));
     var input_el = $($(event.target).parents("div.box-price")).find('.count');
     }
     

 //��������� ��������� ���������� �������
 if($(input_el).length>0 && $(input_el).attr("value")!=''){
     
     //������� �������� ���������� �� ������ ��� ������
     //var na_sklade=Number($(event.target).attr("kol_skl"));
     var input_count = Number($(input_el).attr("value"));//��������� ����������
     
     var regexp = /[\s]/i;  
     na_sklade = Number($(event.target).attr("kol_skl").replace(regexp,''));//���������� �� ������ �������
     
     
     //���������, �� ������ �� ��� �� ������ �������� ��������
     if(input_count > na_sklade)
         {
             input_el.attr("value",na_sklade);
             var too_much=$(parent_input).find('.too_much');//��� � ���������������
             $(too_much).html('� ������� ������� ������ '+na_sklade+' �����������');
             return false;
         }
     else
         {
             var too_much=$(parent_input).find('.too_much');//��� � ���������������
             $(too_much).html(' ');
         }
     }
 else
     {
     input_el.attr("value","1");
     var input_count = '1';
     }
 

var in_cart=$(event.target).parents('div.book-price').find('.in-cart');//��� �������� ����� �������� ������ �������
if(in_cart.length==0)
    in_cart=$(event.target).parents('div.item-info').find('.in-cart');//��� ������ ���� ������ �� �������       
if(in_cart.length==0)
    in_cart=$(event.target).parents('div.box-price').find('.in-cart');//��� ������ ���� ������ �� �������

//����������� ���������� ������� ��� ���� � �������

var tov_vkor=$(in_cart).find('.kol_in_cart').attr('kol_in_cart');

//console.log(tov_vkor);

//console.log((parseInt(input_count)+parseInt(tov_vkor)) > parseInt(na_sklade));
//console//.log(input_count);

//console.log(in_cart);

//console.log(na_sklade);
//console.log(parseInt(input_count)+parseInt(tov_vkor));



if((parseInt(input_count)+parseInt(tov_vkor)) > parseInt(na_sklade) || parseInt(input_count)==0)
         {
             var raznost=parseInt(na_sklade)-parseInt(tov_vkor);
             var too_much=$(parent_input).find('.too_much');//��� � ���������������
             if(raznost>0)
                {
                    $(too_much).html('�� ������ ������ ��� �� ����� '+raznost+' �����������');
                    input_el.attr("value",raznost);
                }
             else if(raznost==0)
                 {
                     $(too_much).html('�� �������� ������������ ��������� ����������');
                     input_el.attr("value",'0');
                 }
             
             return false;
         }


 var href_tov=$(event.target).attr('href')+'&AJAX=1&count='+input_count;
  $.ajax({
        url:href_tov,
        beforeSend:function(){
             $(event.target).after('<span id="gif_load_buy"><img src="/images/snake-loader.gif" border="0"></span>');
            },
        success: function(data){
            //console.log(in_cart);
            
            $(input_el).css('background-color','#BFFFDF');
            $(input_el).attr("value","1");
            
            console.log($(event.target).hasClass('not_write'));
            if(!$(event.target).hasClass('not_write'))
                $(in_cart).html(data);
            
            $("span#gif_load_buy").remove();
            refresh_cart();
        }
    });
 
 /*var href_tov=$(event.target).attr('href')+'&ADD=1';
 $.ajax({
  url: href_tov,
  success: function(data) {
        $(".card").html(data);
      }
    });*/
}

//������� ��� ��������� ������������ �������� ��� ��������� �� ������ � �������� ��������� ���������� ��������� �� �������� �������
var handlerPagination = function(event)
    {
    event.preventDefault();
 
    var href_tov='';
    
    var count_zap=$('#count_zap').attr('count_zap');
    
    if($(event.target).attr('class')=='pagin_kol')
        {
            href_tov=$(event.target).attr('href');//������� ������ �� �������� ��������� ��������
            var count_zap=$(event.target).attr('count_zap');
        }
    else if($(event.target).attr('class')=='pagin')
        {
            href_tov=$(event.target).attr('href');//������� ������ �� �������� ��������� ��������
            var count_zap=$('#count_zap').attr('count_zap');
        }
        
    //alert(href_tov);   
    //console.log(href_tov);
    //������� ������ �������� ���������� ��������
    var regexp = /count_zap=[\d]*/i;  
    href_tov = href_tov.replace(regexp,'');
    
    var regexp = /&AJAX=[\d]*/i;  
    href_tov = href_tov.replace(regexp,'');
    
    var regexp = /&&/i;  
    href_tov = href_tov.replace(regexp,'&');
    
    //alert(href_tov);
    
    //console.log(href_tov);
    
    var arr_tov=href_tov.split(/([\?,])/);
    
    //�������� �� ���� � IE c ��������� ������
    if(arr_tov[2] == undefined)
      {
          var params=arr_tov[1];
      }
    else
      {
          var params=arr_tov[2];
      }
    href_tov=arr_tov[0]+'?'+count_zap+'&AJAX=1&'+params;//���������� �������� ��������
    
    $.ajax({
        type: "POST",
        url:href_tov,
        datatype: "html",
        beforeSend:function()
            {
              $('#preload').html('<img id="gif_load_buy" src="/images/ajax-loader.gif" border="0">');
            },
        success: function(data)
            {
              $('#wrap_sections').html(data);
              $('#preload').html(' ');
            },
        error: function ( xhr, ajaxOptions, thrownError ) {
		$('#wrap_sections').text('jQuery Ajax error! xhr: ' + xhr + '; ajaxOptions: ' + ajaxOptions);
        }
    });
    }


/**
 * ilya - ������� ������� ����� �� �����
*/
var only_num = function(event){
	var key_pr=event.which;
	if( key_pr!=8 && key_pr!=0 && (key_pr<48 || key_pr>57))
  {
	//event.target.value=event.target.value; // 'array'
	return false;
  }
}

//������� ���������� �������� � ����������� �� ��������� ����������
var sort_tov = function(event){
    //alert('123');
    
    if(!($(event.target).hasClass('activ')))
        {

           //���������� ������ �� �������� ����������
            var href_tov=$('#utl_self').attr('utl_self');
            
            //alert(href_tov);
            
            //��������� ����������� ����������
            //console.log(href_tov);

            //������ ����� activ �� ������� ��������,������� ���������� ��� ��� �� ���
            if(event.target.tagName=='SELECT')
                {
                    //������� sort_typ
                    var regexp = /&sort_typ=\w*/i;  
                    href_tov = href_tov.replace(regexp,'');
                    //console.log(href_tov);
                    
                    $('#sort option.activ').removeClass('activ');
                    $(event.target).addClass('activ');
                    
                }
            else if(event.target.tagName=='A'){
                    var nap_sort=$(event.target).attr('id');

                    //������� sort_typ
                    var regexp = /&nap_sort=[\w-]*/i;  
                    href_tov = href_tov.replace(regexp,'');
                    //console.log(href_tov);
            }

            //��������� ����� �� ��������� AJAX=1 � ���������� �������� ��������
            var regexp = /AJAX=1/gi;
            var matches = href_tov.match(regexp);

            var arr_tov=href_tov.split(/([\?,])/);
            
            
            //�������� �� ���� � IE c ��������� ������
            if(arr_tov[2] == undefined)
              {
                  var params=arr_tov[1];
              }
            else
              {
                  var params=arr_tov[2];
              }

            //���������� ��� ����������
            if(event.target.tagName=='SELECT')
                {
                    var sort_typ=$(event.target).attr('value');
           
                    if(!(matches == null))
                        {
                          href_tov=arr_tov[0]+'?&sort_typ='+sort_typ+'&'+params;  
                        }
                    else{

                          href_tov=arr_tov[0]+'?&sort_typ='+sort_typ+'&'+'AJAX=1'+'&'+params;
                    }
                    
                }
            else if(event.target.tagName=='A'){
                
                if(!(matches == null))
                        {
                          href_tov=arr_tov[0]+'?&nap_sort='+nap_sort+'&'+params; 
                        }
                else{

                          href_tov=arr_tov[0]+'?&nap_sort='+nap_sort+'&'+'AJAX=1'+'&'+params;
                    }
            }
            
            //console.log(href_tov);
            
            $.ajax({
                type: "GET",
                url:href_tov,
                datatype: "html",
                beforeSend:function()
                    {
                      $('#preload').html('<img id="gif_load_buy" src="/images/ajax-loader.gif" border="0">');
                    },
                success: function(data)
                    {
                      $('#wrap_sections').html(data);
                      $('#preload').html(' ');
                    },
                error: function ( xhr, ajaxOptions, thrownError ) {
                        $('#wrap_sections').text('jQuery Ajax error! xhr: ' + xhr + '; ajaxOptions: ' + ajaxOptions);
                }
            });
            
            //console.log($(event.target).attr('value'));
            //console.log(href_tov);
        }
}

var tabs_title=function(event){
    
    var a_text=$(event.target).text();
    var span_text=$('.tabs-title span').text();
    
    $('.tabs-title span').after('<a href="#">'+span_text+'</a>');
    $('.tabs-title span').remove();
    
    
    //console.log($(event.target).parent().attr('id'));
    
    //������ ����
    $('.gotov').hide();
    $('.otlozen').hide(); 
    
    $('.'+$(event.target).parent().attr('id')).show();
    
    $(event.target).after('<span>'+a_text+'</span>');
    $(event.target).remove();
    
    //������ � ���������� ��������� ���
    
}

var tabs_ferst_show=function(){
    var child_gotov=$('.gotov').children();
    var child_otl=$('.otlozen').children();
    if((child_gotov.length==0 && child_otl.length==0) || child_gotov.length>0)
     {
          $('.gotov').show();
          $('.otlozen').hide();
     }
     else if(child_gotov.length==0 && child_otl.length>0)
     {
          $('.gotov').hide();
          $('.otlozen').show(); 
          
          var span_text=$('.tabs-title span').text();
          var a_text=$('.tabs-title a').text();
          
          $('#otlozen a').after('<span>'+a_text+'</span>');
          $('#otlozen a').remove();
          
          $('#gotov span').after('<a href="#">'+span_text+'</a>');
          $('#gotov span').remove();
     }

}

var prov_kol_sklad=function(event)
{
    var kol_naskl=parseInt($(event.target).attr('kol_sklad'));
    var input_val=parseInt($(event.target).attr('value'));
    
    
    if(kol_naskl<input_val)
        {
            $(event.target).attr('value',kol_naskl);
            $(event.target).parents('td').find("#warn").remove();
            $(event.target).parents('td').append('<span id="warn" style="color:red">�� ������ ������ '+kol_naskl+'��. </span>');
        }
    else{
        $(event.target).parents('td').find("#warn").remove();
        }

    //console.log($(event.target).parents('td').find("#warn"));

}

//��������� �����
var sub_auth=function(event)
{
    event.preventDefault();
    $('#form_auth').trigger('submit');
}

//������� �����
var sub_skip=function(event)
{
    event.preventDefault();
    console.log($('#form_auth input').attr("value"));
    $('#form_auth input').attr("value","");
}

//���������� �����
var sub_show=function(event)
{
    event.preventDefault();
    $('.box-login').toggle();
}


$(document).ready(function(){//����� ��� ��-�� �������� ��������� �������� �������� ���� � ���������

    //������ ����� �� �����
    $('.count').live("keypress",only_num);
    $('.txt-sm').live("keypress",only_num);
    
    //��������� ���������� ��� ����� �� �������� � �������
    $('.btn-order').live("click",handlerOneTov);
    
    //��������� ���������� ��� ���������
    $('.pagin').live("click",handlerPagination);
    
    //��������� ���������� ��� ���������
    $('.pagin_kol').live("click",handlerPagination);
    
    //��������� ���������� ��� ��������� ��� c������� ���������� �������
    $('#sort').live('change',sort_tov);

    //��������� ���������� ��� ��������� ��� ������ ����������� ����������
    $('.page-sort a').live('click',sort_tov);
    
    //��������� ��������� ������ ��� ������� �� �������� � �������
    $('.delay').live('click',delay_tov);
    $('.vost').live('click',delay_tov);
    $('.del').live('click',delay_tov);

    //��������� ����� ���������� ���� ������ �� ������ ��� �������
    $('.txt-sm').live('keyup',prov_kol_sklad);
    $('.txt-sm').live('change',prov_kol_sklad);
    
    //�������� ����� �����������
    $('#but_auth').live('click',sub_auth);
    $('#but_skip').live('click',sub_skip);
    
    //���������� ����� �����������
    $('#vhod').live('click',sub_show);
    
    //������� ������������ ����� � �������
    //$('.tabs-title a').live('click',tabs_title);
    //tabs_ferst_show();
    //������������� ��������
    $('a.lightbox').lightbox({
      fitToScreen: true
    });
    
    
    // Slide effect
    var _parentSlide = 'div.slide-block';
    var _linkSlide = 'a.open-close';
    var _slideBlock = 'div.block';
    var _openClassS = 'active';
    var _durationSlide = 0;
    
    $(_parentSlide).each(function(){
        if (!$(this).is('.'+_openClassS)) {
         $(this).find(_slideBlock).css('display','none');
        }
    });
    
    $(_linkSlide,_parentSlide).click(function(){
        if ($(this).parents(_parentSlide).is('.'+_openClassS)) {
            $(this).parents(_parentSlide).removeClass(_openClassS);
            $(this).parents(_parentSlide).find(_slideBlock).slideUp(_durationSlide);
            //$(this).text(_textOpenS);
        } else {
            $(this).parents(_parentSlide).addClass(_openClassS);
            $(this).parents(_parentSlide).find(_slideBlock).slideDown(_durationSlide);
            //$(this).text(_textCloseS);
        }
        return false;
    }); 
    
    

});