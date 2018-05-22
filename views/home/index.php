



<?php
if (Session::get("id") == null) {
    ?>
	
	
	<script>
	/*
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    //console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
	  console.log(response.authResponse);
      testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '576074405774349',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };

  // Load the SDK asynchronously


  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
	
		FB.api('/me?fields=name,link,id,email', function(response) {
     // console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response + '!';
		
		var im = response.email;
		var id = response.id;
		$.ajax({
			type:'GET',
            url: "/ajax/",
			data:{
				email: im,
				password: "",
				action: "login"
			},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (res) {
                if (res) {
					console.log(res);
					
                } else {

                    console.log(res);
                }
				
				
            }
        });
		
		
    });
	
  }
  */
</script>

<div id="fb-root"></div>
<script>
/*
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=576074405774349&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
*/
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->


    <div class="container">
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4">
                <div class="card bordered mt-5">
                    <div class="card-body">
                        <h4 class="card-title">Sign-in</h4>
                        <hr/>
						
						<div id="status">
						</div>
                        <form method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                       placeholder="Password">
                            </div>

                            <hr/>
                            <button type="submit" class="btn btn-success">Sign-in</button>
							<hr/>
							<div class="fb-login-button" data-max-rows="1" data-size="large" scope="public_profile, email" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" onlogin="checkLoginState();"style="width: 100%;" data-auto-logout-link="true"></div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    ?>




<div class="card bordered" style="height: 100%;">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="notes">
		
			<?php
				$note = new Note();
				$notes = $note->getOpenNotes();
				
				$x = 0;
				$last_id = "";
				$last_content = "";
				foreach($notes as $res){
					$class = $x == count($notes) - 1 ? "active" : "";
					?>
					<li class="nav-item">
						<a class="nav-link <?=$class?>" href="#" id="<?=$res['note_id']?>">
							<span class="pr-2" id="t_<?=$res['note_id']?>"><?=$res['notes'] == "" ? "New Note": substr(strip_tags($res['notes']), 0, 20)?></span>
							<button type="button" class="close" aria-label="Close" id="<?=$res['note_id']?>">
								<span aria-hidden="true">&times;</span>
							</button>
						</a>
					</li>
				<?php	
				$last_id = $res['note_id'];
				$last_content = $res['notes'];
				$x++;
				}
			?>
		
            
            <li class="nav-item">
                <a class="nav-link" href="#" id="new">
                        New
                </a>
            </li>
			
        </ul>
		<div class="float-right" id="menu" >
			<ul class="navbar-nav">
			<?php if( (Session::get("access")) != null) { ?>
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#uploadModal"><i class="fa fa-arrow-up"></i> Upload Image</a>
                        <a class="dropdown-item" href="#" id="optionBut" data-toggle="modal" data-target="#optionModal"><i class="fa fa-cog"></i> Option</a>
                        <a class="dropdown-item" href="#" id="notesBut" data-toggle="modal" data-target="#notesModal"><i class="fa fa-sticky-note"></i> All notes</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/accounts/logout"><i class="fa fa-arrow-right"></i> Log-out</a>
                    </div>
                </div>
				<?php } ?>
			</ul>
		</div>
    </div>
    <div class="card-body" >

            <input id="id" type="hidden" value="<?=$last_id?>"/>
		
			<div id='editor' contenteditable="true" placeholder="Start typing..."><?=$last_content?></div>
		

    </div>
</div>


    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Insert Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                        <div id="message"></div>
                        <div id="image_preview">
                            <center><img id="previewing" src="/assets/img/default.png" style="width: auto; height: 100%; max-height: 200px; max-width: 400px; " /></div></center>
                        <hr/>
                        <div id="selectImage">
                            <label>Select Your Image</label><br/>
                            <input type="hidden" name="action" value="upload" id="action">
                            <input type="file" name="file" id="file" required class="form-control"/>

                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Insert Image"/>

                </div>
            </div>
            </form>
        </div>
    </div>



    <!-- Option Modal -->
    <div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="optionModal" action="" method="GET" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Options</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="inputLink"><i class="fas fa-link"></i> Create Link</label>
                            <input type="text" class="form-control" id="inputLink" aria-describedby="genLink" placeholder="" disabled>
                            <small id="genLink" class="form-text text-muted" ><a href="#">Create Link</a></small>
                        </div>
                        <hr/>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" name="mode" id="private" value="1" checked >
                                </div>
                                <div class="col-1">
                                    <i class="fas fa-unlock-alt fa-2x text-muted"></i>
                                </div>
                                <div class="col-10">
                                    <label class="form-text">Private</label>
                                    <small class="text-muted" >Only you can view this note.</small>
                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" name="mode" id="public" value="2">
                                </div>
                                <div class="col-1">
                                    <i class="fas fa-book fa-2x text-muted"></i>
                                </div>
                                <div class="col-10">
                                    <label class="form-text">Public</label>
                                    <small class="text-muted" >You choose who can view this note.</small>
                                    <div class="form-group" id="passwordCon" style="display: none;">

                                            <label for="exampleInputPassword1">Set Password</label>
                                            <input type="password" class="form-control" id="pass" placeholder="Password">
                                            <br/>
                                            <button type="button" class="btn btn-success" id="savePass" data-dismiss="modal">Save Password</button>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Notes Modal -->
    <div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">All Notes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 500px; overflow-y: scroll;">
                        <table class="table table-light">
                            <?php
                            $note = new Note();
                            $notes = $note->getNotes();

                            $x = 0;
                            $last_id = "";
                            $last_content = "";
                            foreach($notes as $res){
                                $class = $x == count($notes) - 1 ? "active" : "";
                                ?>

                                <tr class="row-hover">
                                    <td>
                                        <?=substr(strip_tags($res['notes']), 0, 50)?>
                                    </td>
                                    <td width="120px">
                                        <a href="#" id="delete-<?=$res['note_id']?>" class="btn btn-danger delete"><i class="far fa-trash-alt"></i></a>
                                        <?php
                                            if($res['is_open'] == "2") {
                                                ?>
                                                <a href="#" id="open-<?=$res['note_id']?>"  class="btn btn-success open"><i
                                                        class="fas fa-external-link-alt"></i></a>
                                            <?php
                                            }
                                        ?>
                                    </td>
                                </tr>

                                <?php
                                $last_id = $res['note_id'];
                                $last_content = $res['notes'];
                                $x++;
                            }
                            ?>

                        </table>
                    </div>

                </div>

        </
	

<?php
}
?>