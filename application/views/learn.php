
	<?php include('subheader.php'); ?>
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<?php //include('common/sidebar.php'); ?>
		
		<!-- BEGIN CONTENT -->
		<aside class="right-side strech">
			<!-- BEGIN CONTENT HEADER -->
			<section class="content-header">
				<i class="fa fa-align-left"></i>
				<span>Form Wizard</span>
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li><a href="">Forms</a></li>
					<li class="active">Wizard</li>
				</ol>
			</section>
			<!-- END CONTENT HEADER -->
			
			<!-- BEGIN MAIN CONTENT -->
			<section class="content">
				<div class="row">
					<!-- BEGIN FORM WIZARD -->
					<div class="col-md-12">
						<div class="grid">
							<div class="grid-header">
								<i class="fa fa-align-left"></i>
								<span class="grid-title">Form Wizard</span>
								<div class="pull-right grid-tools">
									<a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
									<a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
									<a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
								</div>
							</div>
							<div class="grid-body">
								<div id="rootwizard">
									<div class="navbar">
										<ul>
											<li><a href="#tab1" data-toggle="tab">1</a><span>Basic info</span></li>
											<li><a href="#tab2" data-toggle="tab">2</a><span>Profile detail</span></li>
											<li><a href="#tab3" data-toggle="tab">3</a><span>Setting</span></li>
											<li><a href="#tab4" data-toggle="tab">4</a><span>Finish!</span></li>
											<li><a href="#tab5" data-toggle="tab">5</a><span>Basic info</span></li>
											<li><a href="#tab6" data-toggle="tab">6</a><span>Profile detail</span></li>
											<li><a href="#tab7" data-toggle="tab">7</a><span>Setting</span></li>
											<li><a href="#tab8" data-toggle="tab">8</a><span>Finish!</span></li>
										</ul>
									</div>
									
									<div id="bar" class="progress progress-striped active">
										<div class="bar progress-bar progress-bar-primary"></div>
									</div>
									
									<div class="tab-content">
										<!-- BEGIN BASIC INFO -->
										<div class="tab-pane" id="tab1">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-sm-3 control-label">Firstname</label>
													<div class="col-sm-6">
														<input type="text" name="firstname" id="firstname" class="form-control" placeholder="Your Firstname">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Lastname</label>
													<div class="col-sm-6">
														<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Your Lastname">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Username</label>
													<div class="col-sm-6">
														<input type="text" name="username" id="username" class="form-control" placeholder="Your Username">
													</div>
												</div>
											</div>
										</div>
										<!-- END BASIC INFO -->
										<!-- BEGIN PROFILE DETAIL -->
										<div class="tab-pane" id="tab2">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-sm-3 control-label">Password</label>
													<div class="col-sm-7">
														<input type="password" name="password" id="password" class="form-control" placeholder="Your Password">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Confirm Password</label>
													<div class="col-sm-7">
														<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Your Password (again)">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Email</label>
													<div class="col-sm-7">
														<input type="email" name="email" id="email" class="form-control" placeholder="Your Email">
													</div>
												</div>
											</div>
										</div>
										<!-- END PROFILE DETAIL -->
										<!-- BEGIN SETTINGS -->
										<div class="tab-pane" id="tab3">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-sm-4 control-label">Global Notifications</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch" checked>
													</div>
													<label class="col-sm-2 control-label">Email Notifications</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch" checked>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label">Phone Notifications</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch">
													</div>
													<label class="col-sm-2 control-label">Mail Notifications</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label">Subscribe Newsletters</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch" checked>
													</div>
													<label class="col-sm-2 control-label">RSS Feeds</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch">
													</div>
												</div>
											</div>
										</div>
										<!-- END SETTINGS -->
										<!-- BEGIN FINISH -->
										<div class="tab-pane" id="tab4">
											<div class="finish">
												<h1><i class="fa fa-thumbs-o-up text-light-blue"></i>&nbsp;Yayyy! Congratulations.</h1>
												<button type="button" class="btn btn-success">Get Started</button>
											</div>
										</div>
										<div class="tab-pane" id="tab5">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-sm-3 control-label">Firstname</label>
													<div class="col-sm-6">
														<input type="text" name="firstname" id="firstname" class="form-control" placeholder="Your Firstname">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Lastname</label>
													<div class="col-sm-6">
														<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Your Lastname">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Username</label>
													<div class="col-sm-6">
														<input type="text" name="username" id="username" class="form-control" placeholder="Your Username">
													</div>
												</div>
											</div>
										</div>
										<!-- END BASIC INFO -->
										<!-- BEGIN PROFILE DETAIL -->
										<div class="tab-pane" id="tab6">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-sm-3 control-label">Password</label>
													<div class="col-sm-7">
														<input type="password" name="password" id="password" class="form-control" placeholder="Your Password">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Confirm Password</label>
													<div class="col-sm-7">
														<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Your Password (again)">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Email</label>
													<div class="col-sm-7">
														<input type="email" name="email" id="email" class="form-control" placeholder="Your Email">
													</div>
												</div>
											</div>
										</div>
										<!-- END PROFILE DETAIL -->
										<!-- BEGIN SETTINGS -->
										<div class="tab-pane" id="tab7">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-sm-4 control-label">Global Notifications</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch" checked>
													</div>
													<label class="col-sm-2 control-label">Email Notifications</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch" checked>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label">Phone Notifications</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch">
													</div>
													<label class="col-sm-2 control-label">Mail Notifications</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label">Subscribe Newsletters</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch" checked>
													</div>
													<label class="col-sm-2 control-label">RSS Feeds</label>
													<div class="col-sm-2">
														<input type="checkbox" class="js-switch">
													</div>
												</div>
											</div>
										</div>
										<!-- END SETTINGS -->
										<!-- BEGIN FINISH -->
										<div class="tab-pane" id="tab8">
											<div class="finish">
												<h1><i class="fa fa-thumbs-o-up text-light-blue"></i>&nbsp;Yayyy! Congratulations.</h1>
												<button type="button" class="btn btn-success">Get Started</button>
											</div>
										</div>
										<!-- END FINISH -->
										
										<hr>
										
										<!-- BEGIN WIZARD NAVIGATION -->
										<ul class="pager wizard">
											<li class="previous first" style="display:none;"><a href="#">First</a></li>
											<li class="previous"><a href="#">Previous</a></li>
											<li class="next last" style="display:none;"><a href="#">Last</a></li>
											<li class="next"><a href="#">Next</a></li>
										</ul>
										<!-- END WIZARD NAVIGATION -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END FORM WIZARD -->
				</div>
			</section>
			<!-- END MAIN CONTENT -->
		</aside>
		<!-- END CONTENT -->
		
		<!-- BEGIN SCROLL TO TOP -->
		<div class="scroll-to-top"></div>
		<!-- END SCROLL TO TOP -->
	</div>
