<body class="skin-dark">
<style>
    .widget .value{
    font-size:13px;
    text-align: left;
	height:110px;
   
    }
    .widget .title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }
    .star{
        width:35%;
        margin-left: 1%	;
    }
    .grid-body{
        margin-left: 10px;
    }
	.joined{
	float:right;	
	margin-right:10px;
	font-size:12px;
	}
	.rating{
	font-size:12px;
	width:50%;
	margin-left:10px;
	}
</style>

<?php include('subheader.php'); ?>
	
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<?php include('sidebar.php'); ?>
		
			<!-- BEGIN CONTENT -->
		<aside class="right-side">
			<!-- BEGIN CONTENT HEADER -->
			<section class="content-header">
				<!--<i class="fa fa-home"></i>
				<span>Dashboard</span>
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li class="active">Dashboard</li>
				</ol>-->
			</section>
			<!-- END CONTENT HEADER -->
			
			<!-- BEGIN MAIN CONTENT -->
			<section class="content">
				<div class="row"></div>
				<div class="row" style="margin-top:20px;">
					<!-- BEGIN WIDGET -->
					<div class="col-sm-12">
						<div class="row">
							<?php $i=0; foreach($courses as $cor) {$i++?>
                            <a href="<?php echo base_url()."course/course_detail/".$cor->course_id."/".$i%4;?>"><div class="col-lg-4 col-md-4 col-sm-6">
								<div class="grid widget <?php echo $colors[$i%4]?>">
									<div class="grid-body">
                                        <span class="title"><?php echo $cor->course_name; ?></span>
										<span><img style="margin-left:12%" width="75%" height="100px" src="<?php  echo file_exists(base_url()."images/".$cor->course_image)? base_url()."images/".$cor->course_image : base_url()."images/course.jpg";?>"></span>
                                        <span class="value"><?php echo substr(strip_tags(nl2br($cor->course_description)), 0, 150);  ?></span>
                                        
										<div>
										<span class="rating"> Rating:
										<?php	
											if(isset($rating[$cor->course_id]))
                                                                                        {
                                                                                            switch($rating[$cor->course_id]){
                                                                                                    case 1:
                                                                                                            echo "<img class='star' src='".base_url()."/images/star1.png'>";
                                                                                                            break;
                                                                                                      case 2:
                                                                                                            echo "<img class='star' src='".base_url()."/images/star2.png'>";
                                                                                                            break;
                                                                                                      case 3:
                                                                                                            echo "<img class='star' src='".base_url()."/images/star3.png'>";
                                                                                                            break;
                                                                                                      case 4:
                                                                                                            echo "<img class='star' src='".base_url()."/images/star4.png'>";
                                                                                                            break;
                                                                                                     case 5:
                                                                                                            echo "<img class='star' src='".base_url()."/images/star5.png'>";
                                                                                                            break;

                                                                                                    default:
                                                                                                            echo "<img class='star' src='".base_url()."/images/star0.png'>";
                                                                                                            break;
                                                                                            }
                                                                                        }else{
                                                                                             echo "<img class='star' src='".base_url()."/images/star0.png'>"; 
                                                                                        }
									   
                                         ?>
                                     </span>
									 <span class="joined">Joined : <?php echo isset($courses_members_count[$cor->course_id])?$courses_members_count[$cor->course_id]:0; ?></span>
									</div>
									</div>
								</div>
							</div></a>
                                                        <?php } ?>
                                                    
							
						</div>
					</div>
					<!-- END WIDGET -->
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

	
