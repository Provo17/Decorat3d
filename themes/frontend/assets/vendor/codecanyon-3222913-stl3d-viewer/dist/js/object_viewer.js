function viewer3d(id) {
//    var _this = $(this);

    var canvas = document.getElementById(id);
//    var canvas = _this.closest('.cv');
    var viewer = new JSC3D.Viewer(canvas);
    var ctx = canvas.getContext('2d');
    //Function Definitions
    //====================================================================
    function loadModelByPath($path) {
        viewer.enableDefaultInputHandler(true);
        viewer.replaceSceneFromUrl($path);
        viewer.update();
    }

    function loadFromJSON() {
//        var dataJson = $(document).find('#dataJson').attr('href');;
        var stlpath = $("#" + id).attr('data-href');
//        $.getJSON("data.json",function(ajaxresult){
//        $.getJSON(dataJson, function(ajaxresult) {
        //3D Object loading
//            loadModelByPath(ajaxresult.stlpath);
        loadModelByPath(stlpath);
        viewer.setParameter('InitRotationX', 280);
        viewer.setParameter('InitRotationY', 0);
        viewer.setParameter('InitRotationZ', 0);
        viewer.setParameter('ModelColor', '#7fca18');
        viewer.setParameter('BackgroundColor1', '#EBEBEF');
        viewer.setParameter('BackgroundColor2', '#FFFFFF');
        viewer.setParameter('RenderMode', 'flat');
        viewer.setParameter('Definition', 'high');
        viewer.init();
        viewer.update();
        ctx.font = '17px open sans';
        ctx.fillStyle = '#FF0000';

        //Meta information loading
//            $("#objtitle").text(ajaxresult.objtitle);
//            $("#description").text(ajaxresult.description);
//            $.each(ajaxresult.materials, function(k) {
//                $('<button type="button" class="btn btn-default">' + ajaxresult.materials[k] + '</button>').appendTo("#materials");
//            });
//            $("#price").text(ajaxresult.price);
//            $("#price_subtext").text(ajaxresult.price_subtext);
//        });
    }
    //END Function Definitions
    //====================================================================


    // Handlers
    //=====================================================================
    viewer.afterupdate = function() {
        var catlog_title = $("#" + id).attr('data-description');
        var catalogPrice = $("#" + id).attr('data-catalogPrice');
        var scene = viewer.getScene();
//        var catlog_title = $(this).closest().find('.catlog-title').data('title');
        if (scene !== null && scene.getChildren().length > 0) {
            //DEMO values !
            if (typeof (catlog_title) != 'undefined' && catlog_title != '') {
                ctx.fillText(catlog_title, 180, 290);
            }
            if (typeof (catalogPrice) != 'undefined' && catalogPrice != '') {
                ctx.fillText(catalogPrice, 450, 40);
            }
//            ctx.fillText('Box (mm): 80 x 200 x 100', 10, 20);
//            ctx.fillText('Volume (cc): 10', 10, 35);
            to_image(id);

        }
    };
    //END Handlers
    //====================================================================


    // Execution space
    //=====================================================================

    loadFromJSON();

    //Interaction Tip init and behavior
    $("#tip").hide();
    $("#info").mouseenter(function() {
        $("#tip").fadeIn();
    });
    $("#info").mouseleave(function() {
        $("#tip").fadeOut("slow");
    });

    //Render mode selection events
    $("a.rendermode").click(function(evt) {
        $mode = $(this).attr("href").substr(1);
        viewer.setRenderMode($mode);
        viewer.update();
    });


}
;

function to_image(id) {
//        alert('asd');
    var file_name = $("#" + id).attr('data-rawImageName');
    var uploadDir = $("#" + id).attr('data-uploadDir');
    var canvas = document.getElementById(id);
    var img = canvas.toDataURL("image/png");
    console.log(img);
    $.ajax({
        type: 'POST',
        cache: false,
        data: {uploaded_file: img, file_name: file_name,uploadDir:uploadDir},
        dataType: "json",
        url: $(document).find('#image_save_url').attr('href'),
        success: function(data) {
        }
    });
}
