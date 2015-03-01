<style>
.logo{
padding-top: 14px;
font-size: x-large;
color: rgb(4, 4, 50);
width: 50%;
margin-right: 50%;
}
</style>
	<!-- BEGIN HEADER -->
	<header class="header">
		<!-- BEGIN LOGO -->
		<!--<a href="index.html" class="logo">
			<img src="assets/img/logo.png" alt="Kertas" height="20">
		</a>-->
		<div class="logo" style="border-bottom:1px solid #ccc;"><a href="<?php echo base_url();?>course">Tutor Uncle</a></div>
		<div class="">
		<!-- END LOGO -->
		<!-- BEGIN NAVBAR -->
		<nav class="navbar navbar-static-top" role="navigation" style="background-color:#FFFFFF; border-bottom:1px solid #ccc;">
	
			<!--<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="fa fa-bars fa-lg"></span>
			</a>-->
			
			<!-- BEGIN NEWS TICKER -->
			<!--<div class="ticker" style="background-color:#FFFFFF">
				<form action="#" method="get" class="sidebarform">
					<div class="inputgroup">
						<input type="text" name="search" class="form-control" placeholder="Search...">
						<span style="float:left" class="input-groupbtn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>
			</div>-->
			<!-- END NEWS TICKER -->
			
			<div class="navbar-right" style="border-bottom:1px solid #ccc;">
				<ul class="nav navbar-nav">
					<?php if($this->session->userdata('user_in')!=""){
					 $userData = $this->session->userdata('user_in');
					 if(isset($life_available)){  ?>
						<li style="padding-top:5px;font-size:10px;"><i class="fa fa-user fa-lg"><?php echo $life_available;?></i><input type="hidden" id="life_available" value="<?php echo $life_available;?>" /></li>
					<?php }
					if(isset($coins_available)){  ?>
						<li style="padding-top:5px;font-size:10px;"><i class="fa fa-dollar fa-lg"><?php echo $coins_available;?></i>
					<?php }?>
					 
					<li class="dropdown profile-menu">
						<a href="<?php echo base_url(); ?>/dashbord" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-cog fa-lg"></i>
							<span class="username"><?php echo ucfirst($userData[0]->stud_fname); ?></span>
							<i class="caret"></i>
						</a>
						<ul class="dropdown-menu box profile">
							<li><div class="up-arrow"></div></li>
							<li class="border-top">
								<a href="<?php echo base_url(); ?>/dashboard"><i class="fa fa-user"></i>My Account</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>/signin/logout"><i class="fa fa-power-off"></i>Log Out</a>
							</li>
						</ul>
					</li>
					<?php } else { ?>
						
						<li class="dropdown profile-menu">
							<a href="<?php echo base_url(); ?>/dashbord" class="dropdown-toggle" data-toggle="modal" data-target="#login">
								<i class="fa fa-sign-in fa-lg"></i>
								<span class="username">Login</span>
							</a>
						</li>
						<li class="dropdown profile-menu">
							<a href="<?php echo base_url(); ?>/dashbord" class="dropdown-toggle" data-toggle="modal" data-target="#signup">
								<i class="fa fa-plus-square fa-lg"></i>
								<span class="username">Sign Up</span>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</nav>
		<!-- END NAVBAR -->
	</header>
	<!-- END HEADER -->
	<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
									<div class="modal-wrapper">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-blue">
												<button class="close" aria-hidden="true" data-dismiss="modal" type="button">&times;</button>
												<h4 id="myModalLabel8" class="modal-title">Login</h4>
												</div>
												<div class="modal-body">
													<div class="row">
														<!-- BEGIN LOGIN BOX -->
														<div class="col-lg-3"></div>
														<div class="col-lg-6">
															<div class="account-wall">
																<!-- BEGIN PROFILE IMAGE -->
																
																<!-- END PROFILE IMAGE -->
																<!-- BEGIN LOGIN FORM -->
																<form name="login" method="post" action="<?php echo base_url(); ?>signin" class="form-login">
																	<input type="text" name="email" class="form-control" placeholder="Email" autofocus>
																	<input type="password" name="password" class="form-control" placeholder="Password">
																	<button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
																	
																</form>
																<!-- END LOGIN FORM -->
															</div>
														</div>
														<!-- END LOGIN BOX -->
														<div class="col-lg-3"></div>
													</div>
												</div>
												<!--<div class="modal-footer">
													<div class="btn-group">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="button" class="btn btn-primary">Save changes</button>
													</div>
												</div>-->
											</div>
										</div>
									</div>
								</div>
		<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									<div class="modal-wrapper">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-blue">
												<button class="close" aria-hidden="true" data-dismiss="modal" type="button">&times;</button>
												<h4 id="myModalLabel8" class="modal-title">Sign Up</h4>
												</div>
												<div class="modal-body">
													<div class="row">
														<!-- BEGIN LOGIN BOX -->
														<div class="col-lg-3"></div>
														<div class="col-lg-6">
															<div class="account-wall">
																<!-- BEGIN PROFILE IMAGE -->
																
																<!-- END PROFILE IMAGE -->
																<!-- BEGIN LOGIN FORM -->
																<form name="login" method="post" action="<?php echo base_url(); ?>/login" class="form-login">
																	<input type="text" name="firstname" class="form-control" placeholder="First Name" autofocus>
																	<input type="text" name="secondname" class="form-control" placeholder="Second Name" autofocus>
																	
																	<input type="text" name="email" class="form-control" placeholder="Email" autofocus>
																	<input type="password" name="password" class="form-control" placeholder="Password">
																	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
																	
																</form>
																<!-- END LOGIN FORM -->
															</div>
														</div>
														<!-- END LOGIN BOX -->
														<div class="col-lg-3"></div>
													</div>
												</div>
												<!--<div class="modal-footer">
													<div class="btn-group">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="button" class="btn btn-primary">Save changes</button>
													</div>
												</div>-->
											</div>
										</div>
									</div>
								</div>
								<button class="btn btn-danger" data-toggle="modal" data-target="#modalDanger2" id="modalDanger2_mod" style="display: none;">Danger</button>
	<div class="modal fade" id="modalDanger2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel12" aria-hidden="true">
	    <div class="modal-wrapper">
		    <div class="modal-dialog">
			    <div class="modal-content">
				    <div class="modal-header bg-red">
					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					    <h4 class="modal-title" id="myModalLabel12">Oops!.Life Over</h4>
				    </div>
				    <div class="modal-body">
					    <p>You can regain Life:</p>
					    <p>1. If your coins is below 100, you can regain 10 life with out losing your coins</p>
					    <p>2. If your coins is above 100, you can regain 10 life with a lose of 100 coins</p>
				    </div>
				    <div class="modal-footer">
					    <div class="btn-group">
						<?php $url = base_url().'signin/logout'; ?>
						    <button type="button" class="btn btn-default" data-dismiss="modal" onclick='window.location="<?php echo $url;?>"' >Sign out</button>
						    <button type="button" class="btn btn-danger" id="life_regain_lose">Regain</button>
					    </div>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>