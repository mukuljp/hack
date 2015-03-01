<body class="skin-dark">

    <?php include('subheader.php'); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php include('sidebar_user.php'); ?>

        <!-- BEGIN CONTENT -->
        <aside class="right-side">
            <!-- BEGIN CONTENT HEADER -->
            <section class="content-header">
                <span>Interaction Room</span>
                <?php if($cname<>"") {  foreach ($cname as $courseName) {?>
                <h4>Course :- <?php echo $courseName->course_name;?></h4>
                <?php } } ?>
            </section>
            <!-- END CONTENT HEADER -->

            <!-- BEGIN MAIN CONTENT -->
            <section class="content">
                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        <?php if($discdetail<>""){ foreach($discdetail as $details) { ?>

                            <div class="panel-group" id="accordion<?php echo $details->disc_id; ?>">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $details->disc_id; ?>">
                                                <strong><?php echo $details->disc_title;?></strong> 
                                            </a>
                                        </h4>
										<p><?php echo $details->disc_question;?></p>
                                    </div>
                                    <div id="collapseOne<?php echo $details->disc_id; ?>" class="panel-collapse collapse">
                                        <div class="panel-body">
										<h3>Answers</h3>
											<?php if(isset($details->comments)&& !empty($details->comments)){ foreach($details->comments as $cmt){ ?>
												<div class="row" style="padding:2%">
												<?php echo '<b>'.$cmt->stud_fname.': </b><br/>'.$cmt->rep_reply; ?>
												</div>
											<?php }} else { echo "no answers";} ?>
											<div class="row" style="padding:4%">
													<span><b>Your Answer</b></span><br/>
                                            		<textarea style="width:50%;"></textarea><br/>
													<input type="submit" value="Comment"  >
											</div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        <?php } }?>
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


