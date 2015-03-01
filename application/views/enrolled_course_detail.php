<body class="skin-dark">
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
        .tree a{
            word-wrap: break-word;

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
            text-decoration:none;
            background: chartreuse;
        }
        .tree li.parent_li>span {
            cursor:pointer
        }
        .tree li ul li span {
            background: cornflowerblue;;
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
        .span_disabled{
            background: grey !important;

        }
    </style>
	<script>
            var site_url = "<?php echo base_url();?>"
        </script>
    <?php include('subheader.php'); ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- BEGIN SIDEBAR -->
        <aside class="left-side sidebar-offcanvas">
            <section class="sidebar">
                <div class="tree well" style="margin-top: 151px;">

                    <?php
                    $enabled = true;
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
                                    <span <?php echo ($enabled == true) ? "" : "class='span_disabled'"; ?> ><i class="icon-folder-open"></i> Chapter <?php echo $i; ?></span> <a href=""><?php echo $chapters['chapter']->sy_title; ?></a>
                                    <?php if (count($chapters['subchapters']) > 0) { ?>
                                        <ul>

                                            <?php
                                            $j = 0;
                                            foreach ($chapters['subchapters'] as $subcs) {
                                                $j++;
                                                if (!$subcs->active)
                                                    $enabled = false;
                                                ?>
                                                <li>
                                                    <span <?php echo ($enabled == true) ? "" : "class='span_disabled'"; ?>><i class="icon-minus-sign"></i> Sub - <?php echo $j; ?></span> <a href="<?php echo ($enabled == true) ? base_url() . "course/enrolled_course/$enroll_id/" . $subcs->sy_id : ""; ?>"><?php echo $subcs->sy_title; ?></a>

                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>


                </div>


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
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="blank">Course : <?php echo $course_data[0]->course_name; ?></h3>
                        <?php if (!$course_over) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">Chapter : <?php echo $chapter_data[0]->sy_title; ?></div>
                                <div class="panel-body">
                                    <?php
                                    foreach ($course_contents as $courses) {
                                        if ($courses->cont_contenttype == "desc") {
                                            ?> 
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Description </div>
                                                <div class="panel-body">
                                                    <?php echo $courses->cont_content ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        if ($courses->cont_contenttype == "image") {
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Image </div>
                                                <div class="panel-body">
                                                    <img style="width:100%"src="<?php echo $courses->cont_content ?>"> 
                                                </div>
                                            </div>
                                            <?php
                                        }

                                        if ($courses->cont_contenttype == "video") {
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Video </div>
                                                <div class="panel-body video_block">
                                                    <div id="player"></div>

                                                    <script src="http://www.youtube.com/player_api"></script>

                                                    <script>

                                                        // create youtube player
                                                        var player;
                                                        function onYouTubePlayerAPIReady() {
                                                            player = new YT.Player('player', {
                                                                height: '500',
                                                                width: '100%',
                                                                videoId: "<?php echo $courses->cont_content ?>",
                                                                events: {
                                                                    'onReady': onPlayerReady,
                                                                    'onStateChange': onPlayerStateChange
                                                                }
                                                            });
                                                        }

                                                        // autoplay video
                                                        function onPlayerReady(event) {
                                                            //event.target.playVideo();
                                                        }

                                                        // when video ends
                                                        function onPlayerStateChange(event) {
                                                            if (event.data === 0) {
                                                                //alert('done');
                                                            }
                                                        }

                                                    </script>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php if ($chapter_data[0]->chapt_lastchapter != "") { ?> <button style="background:grey" type="button" class="btn btn-success btn-lg btn-block" >Chapter completed</button><?php } else { ?>
                                        <a href="<?php echo base_url() ?>course/completedstatus/<?php echo $enroll_id . "/" . $chapter_data[0]->sy_id . "/" . $chapter_data[0]->sy_parent; ?>"><button type="button" class="btn btn-success btn-lg btn-block" >Continue to next chapter</button>
                                        <?php } ?>    

                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    Course Over
                                </div>
                            </div>
                        <?php } ?>
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




    <script src="<?php echo base_url(); ?>assets/plugins/jquery-nestable/jquery.nestable.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/plugins/switchery/switchery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/icheck/icheck.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/elearn.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/form.js"></script>
    <script type="text/javascript">

        $(function() {
            $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
            $('.tree li.parent_li > span').on('click', function(e) {
                var children = $(this).parent('li.parent_li').find(' > ul > li');
                if (children.is(":visible")) {
                    children.hide('fast');
                    $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
                } else {
                    children.show('fast');
                    $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
                }
                e.stopPropagation();
            });
        });
    </script>


