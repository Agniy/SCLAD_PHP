

var cl_btn_add=function(event){
	//cчтаем количество добавленных элементов
	event.preventDefault();
	$(event.target).remove();
	
	var kol_row=$('#code_area .row').size()+1;
	
	$('#code_area').append('<div class="row"><div class="form-item short"><input class="code" type="text" size="0" value="" name="form_text_3['+kol_row+']"></div><a class="btn-add" href="#">+Add one more</a></div>');
	
	//console.log($(event.target));
	//console.log(kol_row);
}


$(document).ready(function() {
	var $dialog = $('#popup')
		.dialog({
			autoOpen: false,
                        resizable: true,
                        draggable: true,
                        position: [500,100]
		});

	$('.enquiry').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});

	$('#btn-close').click(function() {
		$('#popup').dialog('close');
		// prevent the default action, e.g., following a link
		return false;
	});
        
     var $dialog_2 =  $('#popup_2')
     .dialog({
		autoOpen: false,
					resizable: true,
					draggable: true,
					position: [500,330]
	});
                
	$('.tracking').click(function() {
		$dialog_2.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        
	$('#btn-close_2').click(function() {
		$('#popup_2').dialog('close');
		// prevent the default action, e.g., following a link
		return false;
	});
	
	$('.btn-add').live('click',cl_btn_add);
        
        
});


