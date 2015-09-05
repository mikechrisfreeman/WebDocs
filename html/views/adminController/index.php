<html>
    <head>
        <?php echo file_get_contents('http://localhost/controller/script/index/' . $this->pageNumber); ?>
    </head>
    <body>
        <?php echo file_get_contents('http://localhost/controller/adminContent/index/' . $this->pageNumber); ?>
    </body>
</html>
<script>

    function disablePlugin(id)
    {
        var plugin = $("#"+id+"plugin").first().val();
        var controller =  $("#"+id+"controller").val();
        var page = $("#"+id+"page").val();
        var resultElem = $("#success" + id);

        var request = "http://localhost/api/webdep/disablePlugin/" + controller +"/" + plugin + "/" + page;
        $.ajax({
            type: "GET",
            url: request,
            success: function (html) {
                alert(html);
                resultElem.addClass("control-group success");
                resultElem.html("Success")
            },
            error: function (xhr, ajaxOptions, thrownError) {
                resultElem.html("Failure : " + thrownError);
                resultElem.addClass("control-group error");
            }
        });

    }

    $(document).ready(function() {

        /*
            Event set for the install plugin
         */
        $( "#installPlugin" ).on( "click", function() {

            var selectedElem = $("#uninstalledPlugins option:selected");
            var pluginName = selectedElem.val();
            var resultElem = $("#installOutcome");


            $.ajax({
                type: "GET",
                url: "http://localhost/api/webdep/installPlugin/" + pluginName,
                success: function (html) {
                    alert(html);
                    resultElem.addClass("control-group success");
                    resultElem.html("Success")
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    resultElem.html("Failure : " + thrownError);
                    resultElem.addClass("control-group error");
                }
            });

        } );


        /*
            Event set for scan plugins
         */
        $( "#scanPlugins" ).on( "click", function() {

            var resultElem = $("#installOutcome");

            $.ajax({
                type: "GET",
                url: "http://localhost/api/webdep/scanPlugins",
                success: function (html) {
                    resultElem.addClass("control-group success");
                    resultElem.html("Success")
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    resultElem.html("Failure : " + thrownError);
                    resultElem.addClass("control-group error");
                }
            });

        } );

        /*
            Setting an event for installed plugins state changes - this will update the controllers list
         */

        $( "#installedPlugins" ).change(function() {

            var selectedPlugin = $("#installedPlugins option:selected");
            var controllers = $( "#controllers" );

            $.ajax({
                type: "GET",
                url: "http://localhost/api/webdep/getAvailableControllersForPlugin/" + selectedPlugin.val(),
                success: function (html) {
                    alert(html);
                    updateControllers(controllers, html);

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.error());
                }
            });
        });

        function updateControllers(controllers, html){
            data = $.parseJSON(html);
            $.each(data, function(i, item) {
                var temp = "<option value='" + item.id + "'>" + item.name + " </option>";
                console.log(temp);
                controllers.append(temp);
                console.log(i + ": " + item );
            });

        }

        $( "#controllers" ).change(function() {

            var selectedController = $("#controllers option:selected");
            var pages = $( "#pages" );

            $.ajax({
                type: "GET",
                url: "http://localhost/api/webdep/getAvailablePagesForController/" + selectedController.val(),
                success: function (html) {
                    alert(html);
                    updatepages(pages, html);

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.error());
                }
            });
        });

        function updatepages(pages, html){
            data = $.parseJSON(html);
            $.each(data, function(i, item) {
                var temp = "<option value='" + item.id + "'>" + item.name + " </option>";
                console.log(temp);
                pages.append(temp);
                console.log(i + ": " + item );
            });
        }

        $( "#enablePlugin" ).on( "click", function() {

            window.alert("i'm here");

            var selectedPlugin = $("#installedPlugins option:selected");
            var selectedController = $("#controllers option:selected");
            var selectedPage = $("#pages option:selected");
            var resultElem = $("#enableOutcome");


            var request =  "http://localhost/api/webdep/enablePlugin/" + selectedController.val() + "/" + selectedPlugin.val() + "/" + selectedPage.val();
            console.log(request);
            $.ajax({
                type: "GET",
                url: request ,
                success: function (html) {
                    alert(html);
                    resultElem.addClass("control-group success");
                    resultElem.html("Success")
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    resultElem.html("Failure : " + thrownError);
                    resultElem.addClass("control-group error");
                }
            });

        } );





    });
</script>

<!--http://localhost/Controller/script/index/888 -->