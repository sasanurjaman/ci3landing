<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="<?php echo strip_tags($this->config->item('site_name')." ".$this->config->item('site_version')." - ".$this->config->item('site_longname'));?>">
        <meta name="author" content="nakulalabs">
        <meta name="keywords" content="<?php echo $this->config->item('site_longname');?>" />
        <title><?php echo (getCompany()->nama != '-' ? getCompany()->nama.' - ' : null).strip_tags($this->config->item('site_longname').' '.$this->config->item('site_version'));?></title>
        
        <!-- favicon -->
        <link rel="Shortcut Icon" href="<?php echo base_url().'images/'.(getCompany()->logo != '-' ? getCompany()->logo : $this->config->item('site_icon'));?>" />
        <!-- Reset all CSS rule -->
        <link rel="stylesheet" href="<?php echo base_url();?>css/reset.css" />
        
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url();?>css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url();?>css/ionicons.min.css">
        <!-- jqueryui -->
        <link rel="stylesheet" href="<?php echo base_url();?>css/jqueryui/jqueryui.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/skins/_all-skins.min.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>css/style.css" />
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery 2.2.3 -->
        <script src="<?php echo base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo base_url();?>js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url();?>js/jquery.number.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
          $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url();?>assets/plugins/fastclick/fastclick.js"></script>
        <!-- jQuery Marquee -->
        <script src="<?php echo base_url();?>js/jquery.marquee.min.js"></script>
        <!-- jssor.slider.min -->
        <script src="<?php echo base_url();?>js/jquery.devrama.slider.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url();?>assets/dist/js/app.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jwplayer.js"></script>
        <script type="text/javascript">jwplayer.key="IzEqVjRNGbvR6o5C9Fa0V+d5RKsU6WMks6OoUQ==";</script>
        <script type="text/javascript">
            $.pageHeight = function(){
                var D = document;
                return Math.max(Math.max(D.body.scrollHeight, D.documentElement.scrollHeight), Math.max(D.body.offsetHeight, D.documentElement.offsetHeight), Math.max(D.body.clientHeight, D.documentElement.clientHeight)); 
            };

            $.pageWidth = function(){
                var D = document;
                return Math.max(Math.max(D.body.scrollWidth, D.documentElement.scrollWidth), Math.max(D.body.offsetWidth, D.documentElement.offsetWidth), Math.max(D.body.clientWidth, D.documentElement.clientWidth)); 
            };
            
            $(window).load(function() {
                $(".se-pre-con").fadeOut("slow");
                getdate();
                runtext();
                runagenda();
                runabsent();
                <?php if (getCompany()->autorefresh > 0):?>
                    setTimeout(refreshData, <?php echo (int)getCompany()->autorefresh*60000?>);
                <?php endif;?>
            });
            
            $(window).resize(function() {
                runagenda();
                runabsent();
            });
            
            function refreshData() 
            {
                /*runvideo();*/
                runtext();
                refreshAgenda();
                refreshAbsent();
                setTimeout(refreshData, 60000);
            }
        
            function getdate()
            {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                if(s<10){
                    s = "0"+s;
                }
                
                $(".time-now").text(h+" : "+m+" : "+s);
                setTimeout(function(){getdate()}, 1000);
            }
            
            var refreshAgenda = function() 
            {
                var htmloop = "";
                var wDiv = $(".projector").width();
                var hDiv = $(".projector").height();
                
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "<?php echo base_url();?>home/runagenda",
                    success: function(d) 
                    {
                        /*console.log( JSON.stringify(d) );*/
                        $("#my-slide .devrama-slider .projector div").remove();
                        $.each(d, function(n, item)                        
                        {                            
                            if (n == 0) {
                                htmloop += "<div class='active' style='display:block;position:absolute;top:0%;left:0%;width:"+wDiv+"px;height:"+hDiv+"px;'>";
                                htmloop += "<table class='table'>";
                                htmloop += "<tr><td width='20%'>Tanggal</td><td>: "+item.tanggal+"</td></tr>";
                                htmloop += "<tr><td width='20%'>Waktu</td><td>: "+item.waktu+"</td></tr>";
                                htmloop += "<tr><td colspan='2'>Acara :<br>"+item.kegiatan+"</td></tr>";
                                htmloop += "<tr><td colspan='2'>Keterangan :<br>"+item.keterangan+"</td></tr>";
                                htmloop += "</table>";
                                htmloop += "</div>";
                            } else {
                                htmloop += "<div style='display:none;position:absolute;top:0px;left:0px;'>";
                                htmloop += "<table class='table'>";
                                htmloop += "<tr><td width='20%'>Tanggal</td><td>: "+item.tanggal+"</td></tr>";
                                htmloop += "<tr><td width='20%'>Waktu</td><td>: "+item.waktu+"</td></tr>";
                                htmloop += "<tr><td colspan='2'>Acara :<br>"+item.kegiatan+"</td></tr>";
                                htmloop += "<tr><td colspan='2'>Keterangan :<br>"+item.keterangan+"</td></tr>";
                                htmloop += "</table>";
                                htmloop += "</div>";
                            }
                            $("#my-slide .devrama-slider .projector").append(htmloop);
                            htmloop = "";
                        });                        
                        $("#my-slide .devrama-slider .button-slider").remove();
                        $('#my-slide').DrSlider();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        /*alert(xhr.statusText);
                        alert(xhr.responseText);*/
                    }
                });                
            }
            
            function runagenda()
            {
                var htmlrun = "";
                var heightPanel = $("#panel3").css("height");
                if ($.pageWidth() >= 1550 && $.pageHeight() >= 850)
                {
                    var wSlide = 365.75;
                    var hSlide = parseInt(heightPanel)-43;
                }
                else if ($.pageWidth() >= 1550 && $.pageHeight() < 850)
                {
                    var wSlide = 365.75;
                    var hSlide = parseInt(heightPanel);
                }
                else if ($.pageWidth() >= 1200 && $.pageHeight() >= 700)
                {
                    var wSlide = 315;
                    var hSlide = parseInt(heightPanel);
                } 
                else if ($.pageWidth() >= 1200 && $.pageHeight() < 700)
                {
                    var wSlide = 315;
                    var hSlide = parseInt(heightPanel)-40;
                }
                
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "<?php echo base_url();?>home/runagenda",
                    success: function(d) 
                    {
                        /*console.log( JSON.stringify(d) );*/
                        $.each(d, function(n, item)
                        {                            
                            htmlrun += "<div>";
                            htmlrun += "<table class='table'>";
                            htmlrun += "<tr><td width='20%'>Tanggal</td><td>: "+item.tanggal+"</td></tr>";
                            htmlrun += "<tr><td width='20%'>Waktu</td><td>: "+item.waktu+"</td></tr>";
                            htmlrun += "<tr><td colspan='2'>Acara :<br>"+item.kegiatan+"</td></tr>";
                            htmlrun += "<tr><td colspan='2'>Keterangan :<br>"+item.keterangan+"</td></tr>";
                            htmlrun += "</table>";
                            htmlrun += "</div>";
                        });
                        
                        $("#my-slide").html(htmlrun).DrSlider({
                            width: wSlide, //slide width
                            height: hSlide,  //slide height
                            showNavigation: false,
                            transitionSpeed: 500,
                            duration: 20000
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        /*alert(xhr.statusText);
                        alert(xhr.responseText);*/
                    }
                });
                
                
            }
            
            var refreshAbsent = function()
            {
                var htmloop = "";
                var wDiv = $(".projector").width();
                var hDiv = $(".projector").height();
                
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "<?php echo base_url();?>home/runabsent",
                    success: function(d) 
                    {
                        /*console.log( JSON.stringify(d) );*/
                        $("#my-absent .devrama-slider .projector div").remove();
                        $.each(d, function(n, item)
                        {
                            if (n == 0) {
                                htmloop += "<div class='active' style='display:block;position:absolute;top:0%;left:0%;width:"+wDiv+"px;height:"+hDiv+"px;'>";
                                htmloop += "<table align='center' class='table'>";
                                htmloop += "<tbody>";
                                htmloop += "<tr><td align='center'>";
                                htmloop += "<img src='<?php echo base_url();?>arsip/photo/"+item.foto+"' width='128' height='128'>";
                                htmloop += "<div class='profile-name'>"+item.nama+"</div>";
                                htmloop += "<div class='profile-pos'>"+item.jabatan+"</div>";
                                htmloop += "</td></tr>";
                                // htmloop += "<tr><td align='center'><span class='btn "+(item.status == "Y" ? "btn-success" : "btn-danger")+" btn-md'>";
                                // htmloop += "<strong>"+(item.status == "Y" ? "ADA" : "KELUAR")+"</strong>";
                                // htmloop += "</span></td></tr>";
                                htmloop += "</tbody>";
                                htmloop += "</table>";
                                htmloop += "</div>";
                            } else {
                                htmloop += "<div class='active' style='display:block;position:absolute;top:0%;left:0%;width:"+wDiv+"px;height:"+hDiv+"px;'>";
                                htmloop += "<table align='center' class='table'>";
                                htmloop += "<tbody>";
                                htmloop += "<tr><td align='center'>";
                                htmloop += "<img src='<?php echo base_url();?>arsip/photo/"+item.foto+"' width='128' height='128'>";
                                htmloop += "<div class='profile-name'>"+item.nama+"</div>";
                                htmloop += "<div class='profile-pos'>"+item.jabatan+"</div>";
                                htmloop += "</td></tr>";
                                // htmloop += "<tr><td align='center'><span class='btn "+(item.status == "Y" ? "btn-success" : "btn-danger")+" btn-md'>";
                                // htmloop += "<strong>"+(item.status == "Y" ? "ADA" : "KELUAR")+"</strong>";
                                // htmloop += "</span></td></tr>";
                                htmloop += "</tbody>";
                                htmloop += "</table>";
                                htmloop += "</div>";
                            }
                            $("#my-absent .devrama-slider .projector").append(htmloop);
                            htmloop = "";
                        });                        
                        $("#my-absent .devrama-slider .button-slider").remove();
                        $('#my-absent').DrSlider();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.statusText);
                        alert(xhr.responseText);
                    }
                });
            }
            
            function runabsent()
            {
                var htmlrun = "";
                var heightPanel = $("#panel3").css("height");
                if ($.pageWidth() >= 1550 && $.pageHeight() >= 850)
                {
                    var wSlide = 365.75;
                    var hSlide = parseInt(heightPanel);
                }
                else if ($.pageWidth() >= 1550 && $.pageHeight() < 850)
                {
                    var wSlide = 365.75;
                    var hSlide = parseInt(heightPanel)-40;
                }
                else if ($.pageWidth() >= 1200 && $.pageHeight() >= 700)
                {
                    var wSlide = 315;
                    var hSlide = parseInt(heightPanel);
                } 
                else if ($.pageWidth() >= 1200 && $.pageHeight() < 700)
                {
                    var wSlide = 315;
                    var hSlide = parseInt(heightPanel)+10;
                }
                
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "<?php echo base_url();?>home/runabsent",
                    success: function(d) 
                    {
                        /*console.log( JSON.stringify(d) );*/
                        $.each(d, function(n, item)
                        {
                            htmlrun += "<div>";
                            htmlrun += "<table align='center' class='table'>";
                            htmlrun += "<tbody>";
                            htmlrun += "<tr><td align='center'>";
                            htmlrun += "<img src='<?php echo base_url();?>arsip/photo/"+item.foto+"' width='128' height='128'>";
                            htmlrun += "<div class='profile-name'>"+item.nama+"</div>";
                            htmlrun += "<div class='profile-pos'>"+item.jabatan+"</div>";
                            htmlrun += "</td></tr>";
                            // htmlrun += "<tr><td align='center'><span class='btn "+(item.status == "Y" ? "btn-success" : "btn-danger")+" btn-md'>";
                            // htmlrun += "<strong>"+(item.status == "Y" ? "ADA" : "KELUAR")+"</strong>";
                            // htmlrun += "</span></td></tr>";
                            htmlrun += "</tbody>";
                            htmlrun += "</table>";
                            htmlrun += "</div>";
                        });
                        
                        $("#my-absent").html(htmlrun).DrSlider({
                            width: wSlide, //slide width
                            height: hSlide,  //slide height
                            showNavigation: false,
                            transitionSpeed: 1000,
                            duration: 5000
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.statusText);
                        alert(xhr.responseText);
                    }
                });
            }
            
            function runtext()
            {
                var $diaplay = $('#display'), counter = 0;
                 
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "<?php echo base_url();?>home/runtext",
                    success: function(d) 
                    {
                        /*console.log( JSON.stringify(d) );*/
                        var runtext = "";
                        $.each(d, function(n, item)
                        {
                            runtext += "["+item.tanggal+"] "+item.judul+(n < d.length ? " | " : "");
                        });
                        
                        $(".marquee")
                            .html("<ul class='marquee-content-items'><li>"+runtext+"</li></ul>")
                            .bind('beforeStarting', function(){
                                $diaplay.show().html('started').delay(1000).fadeOut('fast');
                            })
                            .bind('finished', function(){
                                counter++;
                                $diaplay.show().html('finished ' + counter + ' times').delay(1000).fadeOut('fast');
                            })
                            //Apply plugin
                        .marquee({
                            duration: 15000
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        /*alert(xhr.statusText);
                        alert(xhr.responseText);*/
                    }
                });
            }
            
            $(document).ready(function()
            {
                $(".se-pre-con").bind("ajaxSend", function() {	        
                    $(this).show();
                }).bind("ajaxStop", function() {	        
                    $(this).hide();	    
                }).bind("ajaxError", function() {	        
                    $(this).hide();	    
                });
                
                $("#resolusi").html("[H: "+$.pageHeight()+" W: "+$.pageWidth()+"]");
            });
        </script>
    </head>

    <body class="hold-transition skin-purple layout-top-nav">
        <div class="se-pre-con"></div>
        <div class="wrapper">
            <header class="main-header">
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <a href="<?php echo base_url();?>">
                            <img src="<?php echo (getCompany()->logo != "-" ? base_url().'images/'.getCompany()->logo : $this->config->item('site_icon'));?>" width="64" height="64" alt="logo">
                            <div class="title"><?php echo (getCompany()->nama != "-" ? getCompany()->nama : $this->config->item('site_name').' '.$this->config->item('site_version'));?></div>
                            <div class="subtitle"><?php echo (getCompany()->bagian != "-" ? getCompany()->bagian : $this->config->item('site_longname'));?></div>
                            <div class="moto"><?php echo (getCompany()->moto != "-" ? getCompany()->moto : $this->config->item('site_longname'));?></div>
                            <div class="address"><?php echo (getCompany()->alamat != "-" ? getCompany()->alamat.(getCompany()->kota != '-' ? ' '.getCompany()->kota : null).(getCompany()->kodepos != '-' ? ' '.getCompany()->kodepos : null).(getCompany()->telepon != '-' ? ' Tlp. '.getCompany()->telepon : null).(getCompany()->fax != '-' ? ' Fax. '.getCompany()->fax : null).(getCompany()->email != '-' ? ' Email. '.getCompany()->email : null) : 'web. '.$this->config->item('site_admin').', email. '.$this->config->item('site_email').' <span id="resolusi"></span>');?></div>
                        </a>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
  
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                
                    <!-- Main content -->
                    <?php $this->load->view($content); ?>
                    <!-- /.content -->
                
                <!-- /.container -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer" style="margin:0;padding:0;">
                <div class="row">
                    <div class="col-md-2" style="padding:0;">
                        <div class="news-title">BERITA TERKINI</div>
                    </div>
                    <div class="col-md-8 btn-danger" style="padding:0;">
                        <div class="news-run">
                            <div class="marquee" data-duplicated="true" data-direction="left">&nbsp;</div>
                            <div class="display"></div>
                        </div>
                    </div>
                    <div class="col-md-2 hidden-xs" style="padding:0;">
                        <div class="time-now">&nbsp;</div>
                    </div>
                </div>
            </footer>
            
            <div id="frmdialog" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Danger Modal</h4>
                        </div>
                        <div class="modal-body">
                            <p>One fine body&hellip;</p>
                        </div>
                        <div class="modal-footer">
                            <button name="btnclose" type="button" class="btn btn-outline pull-right" data-dismiss="modal" data-focus="">Tutup</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!-- ./wrapper -->
    </body>
    <script type="text/javascript">
        function runvideo()
        {
            var wPlayer = 0, hPlayer = 0;
        
            if ($.pageWidth() < 1550)
            {
                wPlayer = $("#panel1 .box-body").width();
                hPlayer = wPlayer/1.5;        
            }
            else if ($.pageWidth() >= 1550 && $.pageHeight() >= 850)
            {
                wPlayer = $("#panel1 .box-body").width();
                hPlayer = $("#streaming").height();
            }
            else if ($.pageWidth() >= 1550 && $.pageHeight() < 850)
            {
                wPlayer = $("#panel1 .box-body").width();
                hPlayer = $("#streaming").height();
            }
            else if ($.pageWidth() >= 1200 && $.pageHeight() >= 700)
            {
                wPlayer = $("#panel1 .box-body").width();
                hPlayer = $("#streaming").height();
            }
            else if ($.pageWidth() >= 1200 && $.pageHeight() < 700)
            {
                wPlayer = $("#panel1 .box-body").width();
                hPlayer = $("#streaming").height();
            }
                
            jwplayer("streaming").setup({
                flashplayer: "<?php echo base_url();?>js/jwplayer.flash.swf",
                playlist: <?php echo $runvideo;?>,
                rtmp: { bufferlength: 3 },
                fallback: true,
                width: '100%',
                height: '100%',
                autostart: "true",
                repeat: "always",
                androidhls: true,
                startparam: "start",
                stretching: "exactfit"
            });
        }
        runvideo();
    </script>
</html>