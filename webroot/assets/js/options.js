

$(document).ready(function(){


    (function($) {

        //declare elements
        var editor = $("#editor");
        var id = $("#id");
        var pub = $("#public");
        var priv = $("#private");
        var pass = $("#pass");
        var savePass = $("#savePass");
        var passwordCon =  $("#passwordCon");
        var genLink = $("#genLink");
        var inputLink = $("#inputLink");

        var optionBut = $("#optionBut");



        pub.click(function(e){

            passwordCon.attr('style', 'display: block;');

           setMode(2);

        });

        priv.click(function(e){

            passwordCon.attr('style', 'display: none;');

            setMode(1);

        });

        genLink.click(function(e){

            var url = window.location.href.replace( "#", "" ) + "notes/view/" + id.val();
            inputLink.val(url);

            setLink();

        });


        savePass.click(function(e){

           setPass();

        });

        optionBut.click(function(e){

            getData();

        });



        function setMode(mode){
            $.ajax({
                type:'GET',
                url: "/ajax/notes/",
                data:{
                    id: id.val(),
                    mode: mode,
                    action: "setMode"
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    if (response) {

                        console.log("saved");

                    } else {

                        console.log("error");
                    }
                }
            });
        }



        function setLink(){
            $.ajax({
                type:'GET',
                url: "/ajax/notes/",
                data:{
                    id: id.val(),
                    link: inputLink.val(),
                    action: "setLink"
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    if (response) {

                        console.log("saved");

                    } else {

                        console.log("error");
                    }
                }
            });
        }


        function setPass(){
            $.ajax({
                type:'GET',
                url: "/ajax/notes/",
                data:{
                    id: id.val(),
                    password: pass.val(),
                    action: "setPass"
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    if (response) {

                        console.log("saved");

                    } else {

                        console.log("error");
                    }
                }
            });
        }


        function getData(){
            $.ajax({
                type:'GET',
                url: "/ajax/notes/",
                data:{
                    id: id.val(),
                    action: "getData"
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    if (response) {

                        var datas = [];
                        datas = response;

                        inputLink.val(datas.url);

                        if(datas.mode == "1"){
                            priv.prop('checked', true);
                            passwordCon.attr('style', 'display: none;');
                        }else if (datas.mode == "2") {
                            pub.prop('checked', true);
                            passwordCon.attr('style', 'display: block;');
                        }

                    } else {

                        console.log("error");
                    }
                }
            });
        }


        function uniqueId () {
            // desired length of Id
            var idStrLen = 32;
            // always start with a letter -- base 36 makes for a nice shortcut
            var idStr = (Math.floor((Math.random() * 25)) + 10).toString(36) + "_";
            // add a timestamp in milliseconds (base 36 again) as the base
            idStr += (new Date()).getTime().toString(36) + "_";
            // similar to above, complete the Id using random, alphanumeric characters
            do {
                idStr += (Math.floor((Math.random() * 35))).toString(36);
            } while (idStr.length < idStrLen);

            return (idStr);
        }

    })(jQuery);

//end of document ready

});