$(document).ready(function(){
    $(document).on('click',".confirm-dialog",function(){
       var url=$(this).data('url');
       var message=$(this).data('msg');
       bootbox.confirm(message, function(result) {
  if(result)
  {
      window.location.href=url;
  }
});
    });
});


