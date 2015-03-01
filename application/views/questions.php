<body class="skin-dark">
<?php include('subheader.php'); ?>
	<script>
            var site_url = "<?php echo base_url();?>"
        </script>
	<div class="wrapper row-offcanvas row-offcanvas-left">
            <?php //include('sidebar.php'); ?>
            <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/switchery/switchery.min.css">
             <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/icheck/skins/square/blue.css">
             <link rel="stylesheet" href="<?php echo base_url();?>assets/css/elearn.css">
               <!-- BEGIN CONTENT -->
		<aside class="right-side strech">
			<!-- BEGIN MAIN CONTENT -->
			<section class="content">
				<div class="row">
					<!-- BEGIN FORM WIZARD -->
					<div class="col-md-12">
						<div class="grid">
							<div class="grid-header">
								<i class="fa fa-align-left"></i>
								<span class="grid-title">Chapter Questions</span>
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
                                                                                    <?php if(isset($questions) && !empty($questions)){
                                                                                        $ques_count = count($questions);
                                                                                        for($i=1;$i<=$ques_count;$i++){  ?>
                                                                                            <li data-count="<?php echo $i;?>"><a href="#tab<?php echo $i;?>" data-toggle="tab" ><?php echo $i;?></a><span>Question <?php echo $i;?></span></li>
                                                                                        <?php }?>
                                                                                            <li><a href="#tab<?php echo $i;?>" data-toggle="tab"><?php echo $i;?></a><span>Finish!</span></li>
                                                                                        <?php
                                                                                        } ?>
										</ul>
									</div>
									
									<div id="bar" class="progress progress-striped active">
										<div class="bar progress-bar progress-bar-primary"></div>
									</div>
									
									<div class="tab-content">
										<!-- BEGIN BASIC INFO -->
                                                                            <?php if(isset($questions) && !empty($questions)){
                                                                                foreach($questions as $key=>$question) { $count = $key;++$count; ?>
										<div class="tab-pane tab_questions" id="tab<?php echo $count;?>" data-count="<?php echo $count;?>" rel="qus_<?php echo $question['qus_id'];?>">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-lg-9 col-md-9 col-sm-9 pull-left " 
style="font-size:12px;font-weight:650;"><?php echo $question['qus_questions']; ?>?</label>
													<div class="col-lg-9 col-md-9 col-sm-9">
													    <div class="form-group">
                                                                                                                <?php if(isset($answers[$question['qus_id']]) && !empty($answers[$question['qus_id']])){
                                                                                                                    foreach($answers[$question['qus_id']] as $answer) { ?>
                                                                                                                    <div class="radio">
                                                                                                                            <label><input type="radio" name="radio_<?php echo $question['qus_id'];?>" rel="<?php echo $answer['opt_id']; ?>" class="icheck"><?php echo $answer['opt_name'];?></label>
                                                                                                                    </div>
                                                                                                                    <?php }
                                                                                                                    } else{ ?>
                                                                                                                        <input type="text" name="" id="<?php echo $question['qus_id'];?>" class="form-control" placeholder="Your answer goes here.">
                                                                                                                    <?php } ?>
                                                                                                            </div>
													</div>
												</div>
                                                                                                
                                                                                        </div>
										</div>
                                                                                <?php } ?>
                                                                                <div class="tab-pane" id="tab<?php echo ++$count;?>">
                                                                                        <div class="finish">
                                                                                                <h1><i class="fa fa-thumbs-o-up text-light-blue"></i>Congratulations.</h1>
                                                                                                <button id="finish_submission" type="button" class="btn btn-success">Continue to next Chapter</button>
                                                                                        </div>
                                                                                </div>
                                                                            <?php
                                                                            } ?>
										<!-- END BASIC INFO -->
										
										
										
										
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
        <div class="modal fade" id="modalSuccess2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
            <div class="modal-wrapper">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                    <div class="modal-header bg-green">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel9">Question Summary</h4>
                                    </div>
                                    <div class="modal-body">
                                            
                                    </div>
                                    <div class="modal-footer">
                                            <div class="btn-group">
                                                    <button type="button" class="btn btn-success" id="question_summary" >Ok</button>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </div>
    </div>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalSuccess2" id="modalSuccess2_mod" style="display:none;"></button>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/switchery/switchery.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/icheck/icheck.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/form.js"></script>
	<script type="text/javascript">
		/* FORM WIZARD */
		$('#rootwizard').bootstrapWizard({
			onTabShow: function(tab, navigation, index){
				var $total = navigation.find('li').length;
				var $current = index+1;
				var $percent = ($current/$total) * 100;
				$('#rootwizard').find('.bar').css({
					width:$percent+'%'
				});
			}
		});
		
		if (Array.prototype.forEach) {
			var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
			elems.forEach(function(html) {
				var switchery = new Switchery(html);
			});
		} else {
			var elems = document.querySelectorAll('.js-switch');
			for (var i = 0; i < elems.length; i++) {
				var switchery = new Switchery(elems[i]);
			}
		}
                $("#finish_submission").click(function(){
                    var q_tab_pane = $('.tab_questions').length;
                    var last = 'first';
                    var tab_count = 1;
                    $('.tab_questions').each(function(){
                        var last_ansr = $(this).data('count');
                        var id_val = $("#tab"+last_ansr).attr('rel');
                       
                        var q_ids = id_val.split('_');
                        var q_id = q_ids[1];
                        var ans_name = 'radio_'+q_id;
                        var ans_value = $('input[name="'+ans_name+'"]:checked').attr('rel');
                        if (q_tab_pane==tab_count) {
                            last = "last";
                        }
                        tab_count++;
                        
                        if (ans_value==undefined) {
                            ans_value = 0;
                        }
                        $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('/chapters/saveStudentAnswer'); ?>",
                        data: {"question_id": q_id,"anwr_option": ans_value,"last":last},
                        success: function (data) {
                                    data = JSON.parse(data);
                                    if (data.score_board != "") { 
                                        if(jQuery.isEmptyObject(data.score_board)){}
                                        else{
                                            var html = '<table class="table"><thead><tr><th>Q.No</th><th>R/W</th></tr></thead><tbody>';
                                            
                                            $.each(data.score_board,function(key,val){
                                               
                                                if (val.score_result=="R") {
                                                    var temp = '<div class="col-md-3 col-sm-4"><i class="fa fa-check"></i></div>';
                                                }
                                                else{
                                                    var temp = '<div class="col-md-3 col-sm-4"><i class="fa fa-times"></i></div>'; 
                                                }
                                                var indx = parseInt(key)+1;
                                                html += '<tr><td>'+indx+'</td><td>'+temp+'</td></tr>';
                                            });
                                            html += '</tbody></table>';
                                            
                                            var enroll = data.enroll_id;
                                            var chapter_id = data.chapter_id;
                                            chapter_id = parseInt(chapter_id)+1;
                                            $("#modalSuccess2_mod").trigger('click');
                                            var redir_loc = site_url+"course/enrolled_course/"+enroll+"/"+chapter_id;
                                            $("#modalSuccess2 #question_summary").attr('onclick','window.location="'+redir_loc+'"');
                                            $("#modalSuccess2 .modal-body").append(html);
                                            }
                                    }

                                }
                        });
                    });
                });
	</script>