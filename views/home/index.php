
    <div class="container flex-column flex-sm-row mt-5">
        <div class="row">
			<div class="col d-none d-sm-block  pt-5">
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
					<br/>
					<a href="/signup/" class="btn btn-outline-warning btn-lg btn-round">Sign-up Now!</a>
				</center>
			</div>
		
			<div class="col">
				<div class="card flex-row ml-sm-auto d-sm-flex p-3" style="max-width: 320px;">
					<div class="card-body">
						<center>
							<h6 class="card-title">Sign-in</h6>
							<hr/>
							<div id="status"></div>
						
							<button onclick="javascript:login();" class="btn btn-primary btn-lg" style="background: #4267b2; border: 1px solid #4267b2; width: 100%; ">
								<i class="fa fa-facebook-square"></i> Continue with Facebook
							</button>
							<br/>
							<br/>
						</center>
						
						
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
									   placeholder="Password" autocomplete="current-password">
							</div>

							
							<center>
								<button type="submit" class="btn btn-primary btn-block btn-lg">Sign-in</button>
							</center>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>