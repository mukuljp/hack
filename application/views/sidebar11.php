<!-- BEGIN SIDEBAR -->
		<aside class="left-side sidebar-offcanvas">
			<section class="sidebar">
				<div class="user-panel">
					<!--<div class="pull-left image">
						<img src="assets/img/user/avatar01.png" class="img-circle" alt="User Image">
					</div>
					/*<div class="pull-left info">
						<p>Jeffrey <strong>Williams</strong></p>
						<a href="#"><i class="fa fa-circle text-green"></i> Online</a>
					</div>*/-->
				</div>
				
				<ul class="sidebar-menu">
                                    <?php foreach($categories as $cat){ ?>
					<li class="menu">
						<a href="#">
							<span><?php echo $cat->cata_name ?></span>
						</a>
						<ul class="sub-menu">
                                                    <?php
                                                        foreach($courses as $cor){ 
                                                         if($cor->course_catagory==$cat->cata_id){
                                                         ?>
							<li><a href="ui-general.html"><?php echo $cor->course_name;?></a></li>
                                                         <?php
                                                         
                                                         } 
                                                         
                                                         }?>
						</ul>
					</li>
                                        <?php } ?>
				
				</ul>
				<!--<ul class="sidebar-menu">
					<li class="active">
						<a href="index.html">
							<i class="fa fa-home"></i><span>Dashboard</span>
						</a>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-laptop"></i><span>UI Elements</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="ui-general.html">General</a></li>
							<li><a href="ui-buttons.html">Buttons</a></li>							
							<li><a href="ui-grid.html">Grid</a></li>
							<li><a href="ui-group-list.html">Group List</a></li>
							<li><a href="ui-icons.html">Icons</a></li>
							<li><a href="ui-messages.html">Messages & Notifications</a></li>
							<li><a href="ui-modals.html">Modals</a></li>
							<li><a href="ui-tabs.html">Tabs & Accordions</a></li>
							<li><a href="ui-typography.html">Typography</a></li>
						</ul>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-align-left"></i><span>Forms</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="forms-components.html">Components</a></li>
							<li><a href="forms-masks.html">Input Masks</a></li>
							<li><a href="forms-validation.html">Validation</a></li>
							<li><a href="forms-wizard.html">Wizard</a></li>
							<li><a href="forms-wysiwyg.html">WYSIWYG Editor</a></li>
							<li><a href="forms-upload.html">Multi Upload</a></li>
						</ul>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-table"></i><span>Tables</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="tables-basic.html">Basic Tables</a></li>
							<li><a href="tables-datatables.html">Data Tables</a></li>
						</ul>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-map-marker"></i><span>Maps</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="maps-google.html">Google Map</a></li>
							<li><a href="maps-vector.html">Vector Map</a></li>
						</ul>
					</li>
					<li>
						<a href="charts.html">
							<i class="fa fa-bar-chart-o"></i><span>Charts</span>
						</a>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-archive"></i><span>Pages</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="404.html">404 Page</a></li>
							<li><a href="500.html">500 Page</a></li>
							<li><a href="pages-blank.html">Blank Page</a></li>
							<li><a href="pages-blank-header.html">Blank Page Header</a></li>
							<li><a href="pages-calendar.html">Calendar</a></li>
							<li><a href="pages-code.html">Code Editor</a></li>
							<li><a href="pages-gallery.html">Gallery</a></li>
							<li><a href="pages-invoice.html">Invoice</a></li>
							<li><a href="lockscreen.html">Lock Screen</a></li>
							<li><a href="login.html">Login</a></li>
							<li><a href="register.html">Register</a></li>
							<li><a href="pages-search.html">Search Result</a></li>
							<li><a href="pages-support.html">Support Ticket</a></li>
							<li><a href="pages-timeline.html">Timeline</a></li>
							<li><a href="pages-user.html">User Profile</a></li>
						</ul>
					</li>
					<li>
						<a href="email.html">
							<i class="fa fa-envelope"></i><span>Email</span><small class="badge pull-right bg-blue">12</small>
						</a>
					</li>
					<li>
						<a href="../frontend/index.html">
							<i class="fa fa-flag"></i><span>Frontend</span>
						</a>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-folder-open"></i><span>Menu Levels</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="#">Level 1</a></li>
							<li class="menu">
								<a href="#">
									<span>Level 2</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="sub-menu">
									<li><a href="#">Sub Menu</a></li>
									<li><a href="#">Sub Menu</a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>-->
			</section>
		</aside>
		<!-- END SIDEBAR -->
