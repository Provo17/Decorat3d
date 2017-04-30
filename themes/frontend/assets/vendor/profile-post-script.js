$(document).ready(function() {
    var a;
    var c = {dragClass: "active", on: {load: function(g, d) {

                
                    var f = /image.*/;
                    if (!d.type.match(f)) {
                        alert('File "' + d.name + '" is not a valid image file');
                        return false
                    }
                    if (parseInt(d.size / 1024) > 15000) {
                        alert('File "' + d.name + '" is too big.Max allowed size is 2 MB.');
                        return false
                    }
                    create_box_p(g, d)
             
            }, }};
    var b = {on: {load: function(g, d) {
                var f = /image.*/;
                    if (!d.type.match(f)) {
                        alert('File "' + d.name + '" is not a valid image file');
                        return false
                    }
                    if (parseInt(d.size / 1024) > 15000) {
                        alert('File "' + d.name + '" is too big.Max allowed size is 2 MB.');
                        return false
                    }
                    create_box_p(g, d)
            }, }};
    if ($('body').find("#postDropbox").length > 0) {
        FileReaderJS.setupDrop(document.getElementById("postDropbox"), c);
        FileReaderJS.setupInput(document.getElementById("selectimage_p"), b)
    }
});
create_box_p = function(f, b) {
    var d = Math.floor((Math.random() * 100000) + 3);
    var a = b.name;
    var g = f.target.result;
    var c = '<li class="" id="eachImage_' + d + '"><a href="javascript:void(0);" onclick="delete_post_popup_image('+"'"+ d +"'"+')" class="new_link_close_btn">X</a>';
    c += '<img  style="width:100%;height:auto;" src="' + g + '"><span class="overlay" ><span class="updone" ></span></span>'; // width="281" height="152" style="width:22%;min-width:261px;"
    c += "</span>";
    c += '<div class="progress" id="' + d + '"><span></span></div><input type="hidden" name="post_image_name[]" id="post_image_name_' + d + '" value="" ></li>';

    $("#html_prevew").html(' ');
    $("#post_url").val('');
     $("#post_video_url").val('');
    $("#preview_delete").hide();

    $("#og-grid_p").append(c);
	
    upload_p(b, d)
};
upload_p = function(a, b) {
    var c = new Array();
    c[b] = new XMLHttpRequest();
    c[b].open("post", full_path + "/user/profile-post-image", true);
    c[b].upload.addEventListener("progress", function(d) {

        if (d.lengthComputable) {
            $(".progress[id='" + b + "'] span").css("width", (d.loaded / d.total) * 100 + "%");
            $(".preview[id='" + b + "'] .updone").html(((d.loaded / d.total) * 100).toFixed(2) + "%")
        } else {
            alert("Failed to compute file upload length")
        }
    }, false);
    c[b].onreadystatechange = function(d) {
        if (c[b].readyState === 4) {
            if (c[b].status === 200) {
                $(".progress[id='" + b + "'] span").css("width", "100%");
                $(".preview[id='" + b + "']").find(".updone").html("100%");
                $(".preview[id='" + b + "'] .overlay").css("display", "none");
                $(".progress[id='" + b + "']").fadeOut();

                $("#post_image_name_" + b).val(c[b].responseText);
                $("#profile_post_type").val('1');

                //     var e = '<div class="ED-wrap"> <div class="edit-del">   <a class="al-editBtn" href="javascript:void(0);" onClick="return open_edit_dialogue(\'' + c[b].responseText + '\')">Edit</a>                                <a class="al-delBtn" href="javascript:void(0);" onClick="return open_delete_dialogue(\'' + c[b].responseText + "')\" >Delete</a> </div> </div>";


            } else {
                // alert("Error : Unexpected error while uploading file")
                $("#dialog").dialog({
                    buttons: [
                        {
                            id: "btn-yes",
                            text: "OK",
                            click: function() {
                                $(this).dialog("close");
                            }
                        }
                    ]
                });
            }
        }
    };
    c[b].setRequestHeader("X-File-Name", a.name);
    c[b].setRequestHeader("X-File-Size", a.size);
    c[b].setRequestHeader("X-File-Type", a.type);
    c[b].send(a)
};
