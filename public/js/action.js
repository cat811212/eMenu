$(document).ready(function() {
	$("a[action][data]").click(function() {
        var action=$(this).attr('action');
        var data=$(this).attr('data');
        p(action,data);

    });
    function p(url,data) {
    	$form = $('<form action="'+url+'" method="POST"></form>');
    	$form.append('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">');
    	switch(url){
    		case 'removeorder':
    			$form.append('<input type="hidden" name="order_id" value="'+data+'">');
    		break;
    		case 'removegroup':
    			$form.append('<input type="hidden" name="group_id" value="'+data+'">');
    		break;
    		case 'stopgroup':
    		    $form.append('<input type="hidden" name="group_id" value="'+data+'">');
     		break;
     		case 'delshop':
     			$form.append('<input type="hidden" name="shop_id" value="'+data+'">');
     			break;

    	}
    	$('body').append($form);

        $('form[action="'+url+'"]').submit();
    }	
});