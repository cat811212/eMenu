$(document).ready(function() {
	$("a[action][data]").click(function() {
        var action=$(this).attr('action');
        var data=$(this).attr('data');
        return p(action,data);

    });
    function p(url,data) {
        var m=null;
        var e=null;
      	switch(url){
    		case 'removeorder':
                m="你確定要移除這個餐點？？";
                e='<input type="hidden" name="order_id" value="'+data+'">';
    		break;
    		case 'removegroup':
                m="你確定要刪掉這團？？";
                e='<input type="hidden" name="group_id" value="'+data+'">';
    		break;
    		case 'stopgroup':
                m="你確定所有人都訂完了？？";
                e='<input type="hidden" name="group_id" value="'+data+'">';
     		break;
     		case 'delshop':
                m="要刪除這家店？？";
                e='<input type="hidden" name="shop_id" value="'+data+'">';
     		break;

    	}	
        if(m==null||e==null)
            return false;
        var r = confirm(m);
        if(r == true){
            $f = $('<form action="'+url+'" method="POST"></form>');
            $f.append('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">');
            $f.append(e);
            $('body').append($f);
            $('form[action="'+url+'"]').submit();
            return true;
        }
        return false;
    }	
});