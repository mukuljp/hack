
<body class="skin-dark">
    <script src="<?php echo base_url(); ?>assets/js/d3.min.js"></script>
    <style>

        .title_det{
            height:50px;
            padding: 4px 0 0 40px ;
            font-size: 2em;
        }
        .title_det2{
            height:50px;
            padding: 4px 0 0 25px ;
            font-size: 1.2em;
            font-weight: 800;
        }
        .rate_det{
            font-size: 0.5em;
            float:right;
            width:35%;
            margin-top: 10px;

        }
        .widget .value{
            font-size: 1.2em;
            text-align: left;
        }
        .join_det{
            font-size: 0.5em;
            float:right;
            width:20%;
            margin-top: 10px;
        }
        .star{
            width:40%;
            margin-left: 1%	;
        }
        .star2{
            width:20%;
            margin-left: 1%	;
        }
        .tree {
            min-height:20px;
            padding:19px;
            margin-bottom:20px;
            background-color:#fbfbfb;
            border:1px solid #999;
            -webkit-border-radius:4px;
            -moz-border-radius:4px;
            border-radius:4px;
            -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
            -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
            box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
        }
        .tree li {
            list-style-type:none;
            margin:0;
            padding:10px 5px 0 5px;
            position:relative
        }
        .tree li::before, .tree li::after {
            content:'';
            left:-20px;
            position:absolute;
            right:auto
        }
        .tree li::before {
            border-left:1px solid #999;
            bottom:50px;
            height:100%;
            top:0;
            width:1px
        }
        .tree li::after {
            border-top:1px solid #999;
            height:20px;
            top:25px;
            width:25px
        }
        .tree li span {
            -moz-border-radius:5px;
            -webkit-border-radius:5px;
            border:1px solid #999;
            border-radius:5px;
            display:inline-block;
            padding:3px 8px;
            text-decoration:none
        }
        .tree li.parent_li>span {
            cursor:pointer
        }
        .tree>ul>li::before, .tree>ul>li::after {
            border:0
        }
        .tree li:last-child::before {
            height:30px
        }
        .tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
            background:#eee;
            border:1px solid #94a0b4;
            color:#000
        }
        .slice text {
            font-size: 10pt;
            font-family: Arial;
        } 
        #piechart{
            margin-left: 50px;
            margin-top: 50px;
        }
        .comment{
            margin-left: 1%;
            background-color: #eaeaea;
            width:99%;
            margin-top: 10px;
        }
        .comment span{
            margin-left: 10px;
        }
        .comment textarea{
            width:90%;
            margin: 2%;
        }
        .rate_li {
            list-style: none;
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
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-9"> 
                        <div class="grid widget">

                            <div class=" title_det <?php echo $colors[$colour_id] ?>">
                                <span class=""><?php echo $course[0]->course_name; ?></span>
                                <span class="rate_det">Rating : <?php
                                    if (isset($rating[$course[0]->course_id])) {
                                        switch ($rating[$course[0]->course_id]) {
                                            case 1:
                                                echo "<img class='star' src='" . base_url() . "/images/star1.png'>";
                                                break;
                                            case 2:
                                                echo "<img class='star' src='" . base_url() . "/images/star2.png'>";
                                                break;
                                            case 3:
                                                echo "<img class='star' src='" . base_url() . "/images/star3.png'>";
                                                break;
                                            case 4:
                                                echo "<img class='star' src='" . base_url() . "/images/star4.png'>";
                                                break;
                                            case 5:
                                                echo "<img class='star' src='" . base_url() . "/images/star5.png'>";
                                                break;

                                            default:
                                                echo "<img class='star' src='" . base_url() . "/images/star0.png'>";
                                                break;
                                        }
                                    } else {
                                        echo "<img class='star' src='" . base_url() . "/images/star0.png'>";
                                    }
                                    ?></span>

                            </div>
                            <div class="grid-body">
                                <span class="value"><?php echo nl2br($course[0]->course_description) ?></span>
                                <div class=" title_det2">
                                    #Table Of Contents
                                </div>
                                <div class="tree well">

                                    <?php
                                    //$enabled=true;
                                    if (count($enrolled_course_data) > 0) {
                                        ?>
                                        <ul>
                                            <?php
                                            $i = 0;
                                            foreach ($enrolled_course_data as $chapters) {
                                                $i++;

                                                //print_r($chapters);
                                                ?>

                                                <li>
                                                    <span  ><i class="icon-folder-open"></i> <?php echo $chapters['chapter']->sy_title; ?></span> 
                                                    <?php if (count($chapters['subchapters']) > 0) { ?>
                                                        <ul>

                                                            <?php
                                                            $j = 0;
                                                            foreach ($chapters['subchapters'] as $subcs) {
                                                                $j++;
                                                                ?>
                                                                <li>
                                                                    <span><i class="icon-minus-sign"></i> <?php echo $subcs->sy_title; ?></span> 

                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>


                                </div>



                            </div>
                            <div class="grid-body" >
                                <div class=" title_det2" style="height:20px;">
                                    #User reviews
                                </div>
                                <?php
                                if (!empty($course_comments)) {
                                    foreach ($course_comments as $row) {
                                        ?>
                                        <div class="comment"><span><?php echo nl2br($row->review_text) ?></span>
                                            <br><br><i><span class="com_name"><?php echo ucfirst($row->stud_fname) . " " . ucfirst($row->stud_lname); ?></span><br><span class="com_time"><?php
                                                    $ts = strtotime(str_replace("-", "/", $row->cur_date)) - strtotime(str_replace("-", "/", $row->review_date));
                                                    if ($ts > 31536000)
                                                        $val = round($ts / 31536000, 0) . ' year';
                                                    else if ($ts > 2419200)
                                                        $val = round($ts / 2419200, 0) . ' month';
                                                    else if ($ts > 604800)
                                                        $val = round($ts / 604800, 0) . ' week';
                                                    else if ($ts > 86400)
                                                        $val = round($ts / 86400, 0) . ' day';
                                                    else if ($ts > 3600)
                                                        $val = round($ts / 3600, 0) . ' hour';
                                                    else if ($ts > 60)
                                                        $val = round($ts / 60, 0) . ' minute';
                                                    else
                                                        $val = round($ts) . ' second';

                                                    if ($val > 1)
                                                        $val .= 's';
                                                    echo $val . ' ago';
                                                    ?></span> </i>
                                        </div>
    <?php }
} ?>
                                <div class="comment">
                                    <textarea>write review....</textarea>
                                </div>
                                <div class="comment">
                                    Rate Course : 
                                    <ul class="rate_li">
                                        <li><input name="rate" type="radio"><img class="star2" src="<?php echo base_url(); ?>images/star1.png"></li>
                                        <li><input name="rate" type="radio"><img class="star2" src="<?php echo base_url(); ?>images/star2.png"></li>
                                        <li><input name="rate" type="radio"><img class="star2" src="<?php echo base_url(); ?>images/star3.png"></li>
                                        <li><input name="rate" type="radio"><img class="star2" src="<?php echo base_url(); ?>images/star4.png"></li>
                                        <li><input name="rate" type="radio"><img class="star2" src="<?php echo base_url(); ?>images/star5.png"></li>
                                    </ul>
                                    <button style="margin:10px 0 10px 35%" type="button" class="btn btn-primary btn-radius dropdown-toggle"  data-toggle="modal" data-target="#login2">Rate Course</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">

                        <div class="row">
                            <div class="grid widget">
                                <div class=" title">
                                    <?php $usr_array=$this->session->userdata('user_in'); if(isset($usr_array[0]->course) && in_array($course[0]->course_id, $usr_array[0]->course)){$link="course/enroll_start/".$course[0]->course_id; $value= "START COURSE";}else if($usr_array!=""){$link="course/enroll_new/".$course[0]->course_id; $value= "ENROLL NOW";} ?>
                                    
                                    
                                    <button <?php if(isset($link)) {echo "onclick=\"window.location='".base_url().$link."'\"";}?> class="btn btn-primary" <?php  if($usr_array==""){ ?> data-toggle="modal" data-target="#modalPrimary2"<?php } ?> ><?php echo isset($value)?$value:"ENROLL NOW"; ?> </button>
                                </div>
                                <div class=" title"> <?php echo isset($courses_members_count[$course[0]->course_id]) ? $courses_members_count[$course[0]->course_id] : 0; ?> people joined  </div>
                                <div id="piechart"></div>
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
    <div class="modal fade" id="modalPrimary2" tabindex="-1" role="dialog" aria-labelledby="myModalLabe2" aria-hidden="true">
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
    <script type="text/javascript">

        var w = $("#piechart").width(), //width
                h = $("#piechart").width(), //height
                r = $("#piechart").width() / 3, //radius
                color = d3.scale.category20c();     //builtin range of colors

        data = <?php echo $get_course_piechart_data; ?>;

        var vis = d3.select("#piechart")
                .append("svg:svg")              //create the SVG element inside the <body>
                .data([data])                   //associate our data with the document
                .attr("width", w)           //set the width and height of our visualization (these will be attributes of the <svg> tag
                .attr("height", h)
                .append("svg:g")                //make a group to hold our pie chart
                .attr("transform", "translate(" + r + "," + r + ")")    //move the center of the pie chart from 0, 0 to radius, radius

        var arc = d3.svg.arc()              //this will create <path> elements for us using arc data
                .outerRadius(r);

        var pie = d3.layout.pie()           //this will create arc data for us given a list of values
                .value(function (d) {
                    return d.value;
                });    //we must tell it out to access the value of each element in our data array

        var arcs = vis.selectAll("g.slice")     //this selects all <g> elements with class slice (there aren't any yet)
                .data(pie)                          //associate the generated pie data (an array of arcs, each having startAngle, endAngle and value properties) 
                .enter()                            //this will create <g> elements for every "extra" data element that should be associated with a selection. The result is creating a <g> for every object in the data array
                .append("svg:g")                //create a group to hold each slice (we will have a <path> and a <text> element associated with each slice)
                .attr("class", "slice");    //allow us to style things in the slices (like text)

        arcs.append("svg:path")
                .attr("fill", function (d, i) {
                    return color(i);
                }) //set the color for each slice to be chosen from the color function defined above
                .attr("d", arc);                                    //this creates the actual SVG path using the associated data (pie) with the arc drawing function

        arcs.append("svg:text")                                     //add a label to each slice
                .attr("transform", function (d) {                    //set the label's origin to the center of the arc
                    //we have to make sure to set these before calling arc.centroid
                    d.innerRadius = 0;
                    d.outerRadius = r;
                    return "translate(" + arc.centroid(d) + ")";        //this gives us a pair of coordinates like [50, 50]
                })
                .attr("text-anchor", "middle")                          //center the text on it's origin
                .text(function (d, i) {
                    return data[i].label;
                });        //get the label from our original data array

    </script>


