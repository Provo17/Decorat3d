function click_file()
{
    $("#Quote_image").click();
}


jQuery(function($) {
    //  getConversion();

    var $form = $('#sendmeg');
    $("#Quote_image").on('change', function() {
        $form.bind().submit();
    });
    
    var file_input = $form.find('input[type=file]');

    var ie_timeout = null;//a time for old browsers uploading via iframe
    $form.on('submit', function(e) {
        e.preventDefault();
        var deferred;
        if ("FormData" in window) {

            formData_object = new FormData();//create empty FormData object

            //serialize our form (which excludes file inputs)
            $.each($form.serializeArray(), function(i, item) {
                //add them one by one to our FormData 
                formData_object.append(item.name, item.value);
            });
            //and then add files
            $form.find('input[type=file]').each(function() {
                var field_name = $(this).attr('name');
                //for fields with "multiple" file support, field name should be something like `myfile[]`

                var files = $('#Quote_image').prop('files');

                if (files && files.length > 0) {
                    for (var f = 0; f < files.length; f++) {
                        formData_object.append(field_name, files[f]);
                    }

                }
            });




            deferred = $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                processData: false, //important
                contentType: false, //important
                dataType: 'json',
                data: formData_object,
                success: function() {
                    $('#sendmeg')[0].reset();
                }

            })

        }
        else {
            //for older browsers that don't support FormData and uploading files via ajax
            //we use an iframe to upload the form(file) without leaving the page

            deferred = new $.Deferred //create a custom deferred object

            var temporary_iframe_id = 'temporary-iframe-' + (new Date()).getTime() + '-' + (parseInt(Math.random() * 1000));
            var temp_iframe =
                    $('<iframe id="' + temporary_iframe_id + '" name="' + temporary_iframe_id + '" \
                                                                frameborder="0" width="0" height="0" src="about:blank"\
                                                                style="position:absolute; z-index:-1; visibility: hidden;"></iframe>')
                    .insertAfter($form)

            $form.append('<input type="hidden" name="temporary-iframe-id" value="' + temporary_iframe_id + '" />');

            temp_iframe.data('deferrer', deferred);
            //we save the deferred object to the iframe and in our server side response
            //we use "temporary-iframe-id" to access iframe and its deferred object

            $form.attr({
                method: 'POST',
                enctype: 'multipart/form-data',
                target: temporary_iframe_id //important
            });

            upload_in_progress = true;
            // file_input.ace_file_input('loading', true);//display an overlay with loading icon
            $form.get(0).submit();


            //if we don't receive a response after 30 seconds, let's declare it as failed!
            ie_timeout = setTimeout(function() {
                ie_timeout = null;
                temp_iframe.attr('src', 'about:blank').remove();
                deferred.reject({'status': 'fail', 'message': 'Timeout!'});
            }, 30000);
        }


        ////////////////////////////
        //deferred callbacks, triggered by both ajax and iframe solution
        deferred
                .done(function(result) {//success
            //format of `result` is optional and sent by server
            //in this example, it's an array of multiple results for multiple uploaded files

            var message = '';
            //for(var i = 0; i < result.length; i++) {
            if (result.status == 'ERR') {

                alert(result.msg);


            }
            else {


                // $(".chat").slimScroll({destroy: true});


                $(".chat").append(result.html);
//                    $('.chat').slimScroll({
//					 height: '300px',
//                                         color:'#c40002',
//                                         alwaysVisible: true,
//                                         opacity: '1',
//                                         borderRadius:'0px',
//                                        start:'bottom'
//			    });
                $("#message").val('');

                // $('#sendmeg')[0].reset();

            }
            if (message != '')
            {
                $('#er_msg').delay(300).fadeIn(1500);
                $('#er_msg').html(message);
            }


        }).fail(function(result) {//failure
            $('#er_msg').delay(300).fadeIn(1500);
            $('#er_msg').html('There was an error');
        })
                .always(function() {//called on both success and failure
            if (ie_timeout)
                clearTimeout(ie_timeout)
            ie_timeout = null;
            upload_in_progress = false;
            // file_input.ace_file_input('loading', false);
        });

        deferred.promise();
        // $(".ace-file-input").addClass('hide');
    });


    //when "reset" button of form is hit, file field will be reset, but the custom UI won't
    //so you should reset the ui on your own
    $form.on('reset', function() {
        // $('#sendmeg')[0].reset();

    });





});


   