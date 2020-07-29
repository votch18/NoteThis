<?php
    $theme = 0;

    if (!empty(Session::get('theme'))) {
        $theme = Session::get('theme') == "1" ? 1 : 0;
    }
?>
<!DOCTYPE html>
<html <?=$theme == 1 ? 'dark-theme="dark"' : ''?>>
<head>

    <title><?= Config::get("site_name")?></title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="">
    <link rel=icon href="/assets/img/favicon.png">

    <?php
    if (@$_SERVER['HTTPS'] != "on") {
        ?>
        <script>
            function redrToHttps()
            {
                var splitUrl = (window.location.href).split("://");
                if (splitUrl[0] !== 'https') {
                    var httpURL = window.location.hostname + window.location.pathname + window.location.search;
                    var httpsURL = "https://" + httpURL;
                    window.location = httpsURL;
                }
            }
            //redrToHttps();
        </script>
        <?php
    }
    ?>

    <!--CSS-->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.css">
    <!--<link rel="stylesheet" href="/assets/css/style.css">-->
    <?php
    if ($theme == 0){
        ?>
        <link rel="stylesheet" href="/assets/css/theme/light.css">
        <link rel="stylesheet" href="/assets/css/theme/tinymce/light/style.css">
        <?php
    }else{
        ?>
        <link rel="stylesheet" href="/assets/css/theme/dark.css">
        <link rel="stylesheet" href="/assets/css/theme/tinymce/dark/style.css">
        <?php
    }

    ?>


    <!--Javascript-->
    <script src="/assets/js/jquery-slim.min.js"></script>
    <!--
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/tinymce/tinymce.min.js"></script>

    <script src="/assets/sweetalert/sweetalert.min.js"></script>

</head>
<body>
<div class="loader_con">
	<div class="loader" style="display: block;"></div>
</div>
<div id="fb-root"></div>

<script>
    /**Initialize facebook sdk */
    window.fbAsyncInit = function () {
        FB.init({
            appId: '576074405774349',
            status: true,
            cookie: true,
            xfbml: true,
            version: 'v3.0'
        });
    };

    /**Load the SDK asynchronously */
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    /**Login using facebook account */
    function login() {
        FB.login(function (response) {
            if (response.authResponse) {
                var access_token = FB.getAuthResponse()['accessToken'];
                console.log('Access Token = ' + access_token);
                FB.api('/me?fields=name,link,id,email', function (response) {
                    console.log('Good to see you, ' + response.name + '.');

                    /**Add welcome message */
                    document.getElementById('status').innerHTML = '<div class="alert alert-success">Welcome ' + response.email + '! <br/>We are now taking you to your notes...</div>';

                    var im = response.email;
                    var id = response.id;
                    $.ajax({
                        type: 'GET',
                        url: "/ajax/",
                        data: {
                            email: im,
                            password: "",
                            action: "login"
                        },
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function (res) {
                            if (res) {
                                console.log("Successfully log-in using Facebook account.");
                            } else {
                                console.log("Error logging-in using Facebook account!");
                            }


                        }
                    });

                    /**Redirect to notes page after few seconds to see the message */
                    setTimeout(function () {
                        window.location = "/notes/";
                    }, 1500);
                });
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
            var status = FB.getLoginStatus();
            console.log(status);
        }, {scope: ''});
    }

    /**Facebook Log-out function */
    function logout() {
		window.location = "/accounts/logout/";
		
        FB.logout(function (response) {
            // user is now logged out
        });
    }
</script>

<div id="content" style="display: none">
<?php
if (Session::get("email") == null) {
    include "_template/nav.php";
} else {
    if ((strtolower(App::getRouter()->getController()) == 'notes') && (strtolower(App::getRouter()->getAction()) == 'view')) {
        include "_template/nav.php";
    }
}
?>

<?php echo $content['content_html']; ?>

</div>

<!--Javascript-->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/initTinyMCE.js"></script>
<script>
    var theme = '<?=$theme == 0? '/assets/css/theme/tinymce/light/style.css?' : '/assets/css/theme/tinymce/dark/style.css?'?>';
    console.log(theme);
</script>
<script src="/assets/js/setup.js"></script>
<script src="/assets/js/options.js"></script>
<script>

    /**Initialize drag and drop functions for tab */
    $(document).ready(function () {
        var $tabs = $("ul.nav-tabs").tabs();
        $(".nav-tabs").sortable({
            axis: "x",
            cancel: '.new, .overflow',
            stop: function () {
                $tabs.tabs("refresh");
            }
        });
    });
</script>

</body>
</html>
