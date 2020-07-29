<header class="navbar navbar-light">
    <div class="container">

        <ul class="nav justify-content-center w-100">
		<a class="navbar-brand" href="#">
		 <strong><?= Config::get("site_name") ?></strong>
		<small>Simple note making for all of your devices.</small>

		</a>
  

            <?php if ((Session::get("email")) != null || Session::get("email") != "") { ?>


                <li class="ml-auto" style="padding: 5px 0!important;">
                    <button onclick="javascript:logout();" class="btn"
                            style="background: transparent; padding: 0; margin: 0; border: 0!important;">
                        <a href="#" role="button" class="nav-link" style="border: 0!important; padding: 5px;">
                            <span data-toggle="tooltip" data-placement="top" title="Log-out"><i
                                    class="fa fa-sign-out fa-2x"></i></span></a>
                    </button>
                </li>
            <?php } else { ?>

              <?php
				if (App::getRouter()->getController() == "home" && App::getRouter()->getAction() == "index"){
			  ?>
			  
			
				<li class="ml-auto" style="padding: 5px 0!important;">
				
				<a href="/signup/" role="button" class="nav-link mt-2">
					<strong>
						<span data-toggle="tooltip" data-placement="top" title="Sign-up">
							
							<span class="d-none d-sm-block" >Create an account, it's free.</span>
							<span class="d-block d-sm-none" >Sign-up</span>
							
						
						</strong>
						</a>
				</li>
				 <?php
				}else if(App::getRouter()->getController() == "signup" && App::getRouter()->getAction() == "index"){
			  ?>
			    <li class="ml-auto" style="padding: 5px 0!important;">
					<a href="/" role="button" class="nav-link mt-2">
					<strong>
						<span data-toggle="tooltip" data-placement="top" title="Sign-in">Sign-in</span>
						</strong>
						</a>
				</li>
			 <?php
				}else {
			  ?>
			    
				<li class="ml-auto" style="padding: 5px 0!important;">
				
					<a href="/" role="button" class="nav-link mt-2">
					<strong>
						<span data-toggle="tooltip" data-placement="top" title="Sign-in">Sign-in</span>
						</strong>
						</a>
						
				</li>
				<li class="" style="padding: 5px 0!important;">
					<a href="#" role="button" class="nav-link mt-2" style="border: 0!important; padding: 5px;">|</a>
				</li>
				<li class="" style="padding: 5px 0!important;">
				
					<a href="/signup/" role="button" class="nav-link mt-2" style="border: 0!important; padding: 5px;">
						<strong>
						<span data-toggle="tooltip" data-placement="top" title="Sign-up">
							
							<span class="d-none d-sm-block" >Create an account, it's free.</span>
							<span class="d-block d-sm-none" >Sign-up</span>
							</strong>
						</a>
						
				</li>
					
  
				 <?php
				}
			  ?>	 

               
            <?php } ?>


        </ul>
</header>