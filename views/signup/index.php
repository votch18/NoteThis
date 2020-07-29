<div class="container flex-column flex-sm-row mt-5">
         <div class="row">
			<div class="col d-none d-sm-block">
				<center>
					<p style="font-size: 24px;">
						<span style="color: #fcbb01;"><i class="fa fa-users fa-5x"></i></span>
						<span style="line-height: 1; color: #0072bb; height: 24px; width: 24px; border-radius: 50%; padding: 10px; margin-left: -20px;"><i class="fa fa-share"></i></span>
						
						
					</p>
					
					<p style="font-size: 20px;">
						Share notes with friends and colleagues. 
						
					</p>
					
					<p style="font-size: 20px;">
					Tab-based layout makes organization so easy.
					</p>
					
				</center>
			</div>
		
			<div class="col">
		
				<div class="card flex-row ml-sm-auto d-sm-flex p-3" style="max-width: 320px;">
				<div class="card-body">
					<h6>Create an account, it's free.</h5>
					<hr/>
					<?php
					if (Session::hasFlash()) {
						?>
						<div class="alert alert-danger" role="alert">
							Email is already taken!
						</div>
					<?php
					}
					?>
					<form method="POST">
						<div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" name="email" class="form-control" id="exampleInputEmail1"
								   aria-describedby="emailHelp" placeholder="Enter email">
							<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
								else.
							</small>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" name="password" class="form-control" id="exampleInputPassword1"
								   placeholder="Password">
						</div>
						
						<button type="submit" class="btn btn-primary">Sign-up</button>
						<br/>
					</form>
						<hr/>
						<p>Already have an account? <a href="/">Sign-in</a></p>
				</div>
			</div>
			</div>
		</div>
    </div>