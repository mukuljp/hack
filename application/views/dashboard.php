<body class="skin-dark">

    <?php include('subheader.php'); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php include('sidebar_user.php'); ?>

        <!-- BEGIN CONTENT -->
        <aside class="right-side">
            <!-- BEGIN CONTENT HEADER -->
            <section class="content-header" style="border-bottom:1px solid #ccc;">
                <span><h3>Summary</h3></span>
            </section>
            <!-- END CONTENT HEADER -->
			<br/>
            <!-- BEGIN MAIN CONTENT -->
			 
            <section class="content">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
								<div class="grid widget bg-light-blue">
									<div class="grid-body">
										<span class="title">Total Coins</span>
										<span class="value"><?php echo $coins_available; ?></span>
										<span class="stat1 chart"><canvas width="120" height="20" style="display: inline-block; vertical-align: top; width: 120px; height: 20px;"></canvas></span>
									</div>
								</div>
					</div>
				<div class="col-sm-6"></div>
				</div>
				</section>
				
				<section class="content-header" style="border-bottom:1px solid #ccc;">
                	<span><h3>Courses</h3></span>
            	</section>
				<br/>
				<section class="content">
                <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <?php
                                if ($course <> "") {
                                    foreach ($course as $courses) { 
                                        ?>
										<div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="grid widget">
                                            	<div class="grid-body">
                                                <span style="font-size:xx-large;"><?php echo $courses->course_name; ?></span><br/>
												<span>Status - Completed</span>
												</div>
												</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4">
													<div class="grid widget">
                                            		<div class="grid-body" align="center" style="color:#FF0000;">
													<span>Coins</span> <br/> 
													<span style="font-size:xx-large;"><?php echo $course_data[$courses->course_id]; ?></span>
													</div>
													</div>
												</div>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
													<div class="grid widget">
                                            			<div class="grid-body" align="center">
														<span>Want to earn more ??</span> <br/> 
															<a href="<?php echo base_url(); ?>dashboard/course_discussion/<?php echo $courses->course_id; ?>"><button class="btn btn-info" type="button">Go To Discussion</button></a>
														</div>
													</div>
                                            	</div>

                                        </div>
                                    <?php }
                                }
                                ?>
                            </div>
							
                        </div>
                    </div>

                </div>
            </section>
            <!-- END MAIN CONTENT -->
        </aside>
        <!-- END CONTENT -->
        <!-- BEGIN SCROLL TO TOP -->
        <div class="scroll-to-top"></div>
        <!-- END SCROLL TO TOP -->
    </div>


