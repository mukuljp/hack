<!-- BEGIN SIDEBAR -->
		<aside class="left-side sidebar-offcanvas">
			<section class="sidebar">
			<?php if($this->session->userdata('user_in')!=""){
					 $userData = $this->session->userdata('user_in');
					 }
					 ?>
				<div class="user-panel">
					<div class="pull-left info">
						<p><i class="fa fa-user"></i>
						<?php echo $userData[0]->stud_fname.' '.$userData[0]->stud_lname; ?> <strong></strong></p>
						<a href="#"><i class="fa fa-circle text-green"></i> Intermediate</a>
					</div>
				</div>
				
				<ul class="sidebar-menu" style="margin-top:20px;">
					<li class="active">
						<a href="<?php echo base_url(); ?>dashboard">
							<i class="fa fa-home"></i><span>Dashboard</span>
						</a>
					</li>
					<li class="">
						<a href="#">
							<i class="fa fa-user"></i><span>Profile</span>
						</a>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-align-left"></i><span>Score Board</span>
						</a>
						<!--<ul class="sub-menu">
							<li><a href="forms-components.html">Components</a></li>
							<li><a href="forms-masks.html">Input Masks</a></li>
							<li><a href="forms-validation.html">Validation</a></li>
							<li><a href="forms-wizard.html">Wizard</a></li>
							<li><a href="forms-wysiwyg.html">WYSIWYG Editor</a></li>
							<li><a href="forms-upload.html">Multi Upload</a></li>
						</ul>-->
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-table"></i><span>Test History</span>
							<!--<i class="fa fa-angle-left pull-right"></i>-->
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>redemption">
							<i class="fa fa-table"></i><span>Redeem Now </span>
							<!--<i class="fa fa-angle-left pull-right"></i>-->
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-cog"></i><span>Settings</span>
							<!--<i class="fa fa-angle-left pull-right"></i>-->
						</a>
					</li>
			</section>
		</aside>
		<!-- END SIDEBAR -->
