<body class="skin-dark">
<?php include('subheader.php'); ?>
	
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<?php include('sidebar.php'); ?>
		
		<!-- BEGIN CONTENT -->
		<aside class="right-side">
			<!-- BEGIN CONTENT HEADER -->
			<section class="content-header">
				<i class="fa fa-home"></i>
				<span>Dashboard</span>
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li class="active">Dashboard</li>
				</ol>
			</section>
			<!-- END CONTENT HEADER -->
			
			<!-- BEGIN MAIN CONTENT -->
			<section class="content">
				<div class="row">
					<!-- BEGIN WIDGET -->
					<div class="col-sm-12">
						<div class="row">
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-light-blue">
									<div class="grid-body">
										<span class="title">VISITS</span>
										<span class="value">18,722</span>
										<span class="stat1 chart">&nbsp;</span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-green">
									<div class="grid-body">
										<span class="title">CLIENTS</span>
										<span class="value">94,263</span>
										<span class="stat2 chart">&nbsp;</span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-purple">
									<div class="grid-body">
										<span class="title">SALES</span>
										<span class="value">5,420</span>
										<span class="stat3 chart">&nbsp;</span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-red">
									<div class="grid-body">
										<span class="title">PROFIT</span>
										<span class="value">$8,270</span>
										<span class="stat4 chart">&nbsp;</span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-orange">
									<div class="grid-body">
										<span class="title">ORDERS</span>
										<span class="value">184</span>
										<span class="stat5 chart">&nbsp;</span>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="grid widget bg-teal">
									<div class="grid-body">
										<span class="title">TICKETS</span>
										<span class="value">1,899</span>
										<span class="stat6 chart">&nbsp;</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END WIDGET -->
				</div>
				<div class="row">
					<!-- BEGIN STATS -->
					<div class="col-md-8">
						<div class="grid current-stat no-border">
							<div class="grid-header">
								<div class="row">
									<div class="col-lg-6 col-xs-12">
										<h3>WEBSITE STATS</h3>
										<h4>20/06/2014</h4>
									</div>
									<div class="col-lg-2 col-xs-12">
										<div class="grid text-center">
											<h4>Yesterday</h4>
											<span class="stat7">&nbsp;</span>
										</div>
									</div>
									<div class="col-lg-2 col-xs-12">
										<div class="grid text-center">
											<h4>Today</h4>
											<span class="stat8">&nbsp;</span>
										</div>
									</div>
									<div class="col-lg-2 col-xs-12">
										<div class="grid text-center">
											<h4>Average</h4>
											<span class="stat9">&nbsp;</span>
										</div>
									</div>
								</div>
							</div>
							<div class="grid-body full">
								<div id="chart-area" style="width:100%; height:380px;"></div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12">
								<div class="grid stat bg-blue">
									<div class="grid-body">
										<h4>Today's Stock <small class="pull-right">29% higher</small></h4>
										<div id="chart-line" style="width:100%; height:120px;"></div>
									</div>
									<div class="footer">
										<h4>Total Stock: <span class="pull-right">8,762,023</span></h4>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="grid stat bg-aqua">
									<div class="grid-body">
										<h4>Today's Earning <small class="pull-right">15% higher</small></h4>
										<div id="chart-bar" style="width:100%; height:120px;"></div>
									</div>
									<div class="footer">
										<h4>Total Earning: <span class="pull-right">$2,384,221</span></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END STATS -->
				</div>
				<div class="row">
					<!-- BEGIN PROFILE -->
					<div class="col-md-4">
						<div class="grid box-profile bg-red">
							<div class="grid-body">
								<img src="assets/img/user/avatar01.png" class="img-circle" alt="User Profile">
								<h3>Jeffrey Williams</h3>
								<span>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod</span>
							</div>
							<div class="footer clearfix bg-red">
								<div class="col-xs-4">
									<div class="grid-body full">
										<h3><i class="fa fa-facebook-square"></i> 823k</h3>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="grid-body full">
										<h3><i class="fa fa-twitter"></i> 402k</h3>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="grid-body full">
										<h3><i class="fa fa-linkedin-square"></i> 97k</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PROFILE -->
					<!-- BEGIN WORK PROGRESS -->
					<div class="col-md-8">
						<div class="grid work-progress no-border">
							<div class="grid-header">
								<span class="title">Work Progress <span class="pull-right">June 20<sup>th</sup>, 14</span></span>
								<span class="sub-title text-blue">Jeffrey Williams</span>
							</div>
							<div class="grid-body">
								<div class="table-responsive">
									<table class="table table-hover">
										<tbody>
											<tr>
												<td>1</td>
												<td>Database Migration</td>
												<td>08/06/2014</td>
												<td><span class="label label-primary">80%</span></td>
												<td><span class="text-green"><i class="fa fa-angle-up"></i>30%</span></td>
											</tr>
											<tr>
												<td>2</td>
												<td>Mobile Development</td>
												<td>21/03/2014</td>
												<td><span class="label label-warning">45%</span></td>
												<td><span class="text-red"><i class="fa fa-angle-down"></i>12%</span></td>
											</tr>
											<tr>
												<td>3</td>
												<td>Server Upgrade</td>
												<td>14/05/2014</td>
												<td><span class="label label-success">51%</span></td>
												<td><span class="text-green"><i class="fa fa-angle-up"></i>40%</span></td>
											</tr>
											<tr>
												<td>4</td>
												<td>App Deployment</td>
												<td>01/01/2014</td>
												<td><span class="label label-danger">10%</span></td>
												<td><span class="text-blue"><i class="fa">-</i>0%</span></td>
											</tr>
											<tr>
												<td>5</td>
												<td>Backup Data</td>
												<td>07/02/2014</td>
												<td><span class="label label-default">78%</span></td>
												<td><span class="text-red"><i class="fa fa-angle-down"></i>10%</span></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- END WORK PROGRESS -->
				</div>
				<div class="row">
					<!-- BEGIN CALENDAR -->
					<div class="col-md-8">
						<div class="grid box-calendar">
							<div class="row">
								<div class="col-md-6 no-padding-right">
									<div class="grid-body bg-purple">
										<span class="date">
											20
										</span>
										<hr>
										<span class="notification">
											<i class="fa fa-bell-o"></i> Jane's Birthday
										</span>
									</div>
								</div>
								<div class="col-md-6 no-padding-left">
									<div class="grid-body full">
										<div id="datetimepicker" data-date="2014-06-20T05:25:07Z" data-date-format="dd-mm-yyyy HH:ii">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END CALENDAR -->
					<!-- BEGIN WEATHER -->
					<div class="col-md-4">
						<div class="grid weather bg-blue">
							<div class="grid-body full">
								<h3 class="title"><i class="fa fa-map-marker"></i> New York<span class="pull-right">64<sup>&deg;</sup></span></h3>
								<canvas class="weather-icon" id="partly-cloudy-day" width="200" height="200"></canvas>
								
								<div class="footer">
									<div class="row">
										<div class="col-xs-2">
											MON
											<canvas class="weather-icon" id="clear-day" width="20" height="20"></canvas>
										</div>
										<div class="col-xs-2">
											TUE
											<canvas class="weather-icon" id="rain" width="20" height="20"></canvas>
										</div>
										<div class="col-xs-2">
											WED
											<canvas class="weather-icon" id="wind" width="20" height="20"></canvas>
										</div>
										<div class="col-xs-2">
											THU
											<canvas class="weather-icon" id="snow" width="20" height="20"></canvas>
										</div>
										<div class="col-xs-2">
											FRI
											<canvas class="weather-icon" id="sleet" width="20" height="20"></canvas>
										</div>
										<div class="col-xs-2">
											SAT
											<canvas class="weather-icon" id="partly-cloudy-night" width="20" height="20"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END WEATHER -->
				</div>
				<div class="row">
					<!-- BEGIN MAP -->
					<div class="col-md-6">
						<div class="grid">
							<div id="vector-map" style="width:100%; height:450px"></div>
						</div>
					</div>
					<!-- END MAP -->
					<!-- BEGIN OS STAT -->
					<div class="col-md-6">
						<div class="grid visitor">
							<div class="grid-body full">
								<h3>OS Audience Stats<span class="pull-right">Week 24</span></h3>
								<div id="chart-donut" class="chart" style="width:100%; height:250px;"></div>
							</div>
							<div class="footer">
								<div class="row">
									<div class="col-md-3 blue">
										<span class="os"><i class="fa fa-windows"></i> Windows</span>
										<span class="percent">30%</span>
									</div>
									<div class="col-md-3 green">
										<span class="os"><i class="fa fa-apple"></i> Mac OS</span>
										<span class="percent">35%</span>
									</div>
									<div class="col-md-3 red">
										<span class="os"><i class="fa fa-linux"></i> Linux</span>
										<span class="percent">20%</span>
									</div>
									<div class="col-md-3 yellow">
										<span class="os"><i class="fa fa-repeat"></i> Other</span>
										<span class="percent">15%</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END OS STAT -->
				</div>
			</section>
			<!-- END MAIN CONTENT -->
		</aside>
		<!-- END CONTENT -->
		
		<!-- BEGIN SCROLL TO TOP -->
		<div class="scroll-to-top"></div>
		<!-- END SCROLL TO TOP -->
	</div>

	
