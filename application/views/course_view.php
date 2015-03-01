<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    .widget .value{
    font-size:15px;
    text-align: left;
   
    }
    .widget .title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }
    .star{
        width:100px;
        margin-left: 25px;
    }
    .grid-body{
        margin-left: 10px;
    }
</style>
<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- BEGIN SIDEBAR -->
		<aside class="left-side sidebar-offcanvas">
			<section class="sidebar">
				<form action="#" method="get" class="sidebar-form">
					<div class="input-group">
						<input type="text" name="search" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>
				<ul class="sidebar-menu">
                                    <?php foreach($categories as $cat){ ?>
					<li class="menu">
						<a href="#">
							<i class="fa fa-laptop"></i><span><?php echo $cat->cata_name ?></span>
							<i class="fa fa-angle-left pull-right"></i>
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
			</section>
		</aside>
		<!-- END SIDEBAR -->
		
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
							<?php foreach($courses as $cor) {?>
                                                        <div class="col-lg-4 col-md-4 col-sm-6">
								<div class="grid widget bg-light-blue">
									<div class="grid-body">
                                                                            <span class="title"><?php echo $cor->course_name; ?></span>
										<span><img style="margin-left:30px" width="200px" height="100px" src="<?php echo base_url()."images/".$cor->course_image;?>"></span>
                                                                                <span class="value"><?php echo nl2br($cor->course_description); ?></span>
                                                                                <span> Rating:
										<?php
                                                                                    switch($cor->course_rating){
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
                                                                               
                                                                                ?>
                                                                                </span>

									</div>
								</div>
							</div>
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
