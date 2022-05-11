<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="<?php echo strip_tags($this->config->item('site_name').", ".$this->config->item('site_smallname').", ".$this->config->item('site_longname')." ".$this->config->item('site_version'));?>">
        <meta name="author" content="<?php echo $this->config->item('site_author');?>">
        <meta name="keywords" content="<?php echo strip_tags($this->config->item('site_smallname').' '.$this->config->item('site_longname'));?>" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
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
        <!-- daterange picker -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datepicker/datepicker3.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/all.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/morris/morris.css">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/skins/_all-skins.min.css">
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
        <!-- jQuery number 2.1.3 -->
        <script src="<?php echo base_url();?>js/jquery.number.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
          $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script src="<?php echo base_url();?>js/raphael-min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/morris/morris.min.js"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url();?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url();?>assets/plugins/fastclick/fastclick.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url();?>assets/plugins/select2/select2.full.min.js"></script>
        <!-- InputMask -->
        <script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- date-range-picker -->
        <script src="<?php echo base_url();?>js/moment.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="<?php echo base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- bootstrap time picker -->
        <script src="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo base_url();?>assets/dist/js/app.min.js"></script>
        <script type="text/javascript">
            var interval;
            var idleTime = 0;
            var sesi = 0;
            var timeNow = function() {
                var currentTime = new Date();
                var currentHours = currentTime.getHours();
                var currentMinutes = currentTime.getMinutes();
                var currentSeconds = currentTime.getSeconds();
                currentHours = (currentHours < 10 ? "0" : "") + currentHours;
                currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
                currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
                
                $(".runTime").html(currentTimeString);
            }
            
            var DisableBackButton = function() {
                window.history.forward();
            }
            
            var timerIncrement = function()
            {
                idleTime = idleTime + 1;
                
                if (idleTime == 15 && sesi == 1) 
                { // 10 minutes
                    sesi = 0;
                    window.location.href = "<?php echo base_url()."dashboard/signout";?>";
                }
                else if (idleTime == 5 && sesi == 0) 
                { // 5 minutes
                    sesi = 1;
                    $("#frmlogout").removeClass().addClass("modal fade modal-danger").modal("show");
                }
            }
            
            $(window).load(function() {
                $(".se-pre-con").fadeOut("slow");
                DisableBackButton();                
                setInterval(timerIncrement, 60000);
                setInterval(timeNow, 1000);
            });
            window.onpageshow = function(e) { if (e.persisted) DisableBackButton() }
            window.onunload = function() { void (0) }
            
            $(document).ready(function()
            {
                (function($){
                    $.fn.focused = function() {
                        this.focus();
                        var $thisVal = this.val();
                        this.val('').val($thisVal);
                        return this;
                    };
                    $.fn.enter = function (fnc) {
                        return this.each(function () {
                            $(this).keypress(function (ev) {
                                var keycode = (ev.keyCode ? ev.keyCode : ev.which);
                                if (keycode == '13') {
                                    fnc.call(this, ev);
                                }
                            })
                        })
                    }
                })(jQuery);
                
                $.docHeight = function() {
                    var D = document;
                    return Math.max(Math.max(D.body.scrollHeight, D.documentElement.scrollHeight), Math.max(D.body.offsetHeight, D.documentElement.offsetHeight), Math.max(D.body.clientHeight, D.documentElement.clientHeight)); 
                };
                
                $.docWidth = function() {
                    var D = document;
                    return Math.max(Math.max(D.body.scrollWidth, D.documentElement.scrollWidth), Math.max(D.body.offsetWidth, D.documentElement.offsetWidth), Math.max(D.body.clientWidth, D.documentElement.clientWidth)); 
                };
                
                $.colXS = function() {
                    return ($.docWidth() < 768 ? 1 : 0);
                }
                
                $.colSM = function() {
                    return ($.docWidth() > 767 && $.docWidth() < 992 ? 1 : 0);
                }
                
                $.colMD = function() {
                    return ($.docWidth() > 991 && $.docWidth() < 1200 ? 1 : 0);
                }
                
                $.colLG = function() {
                    return ($.docWidth() > 1199 ? 1 : 0);
                }
                
                $.classTable = function() {
                    if ($.colXS()) { /*.col-xs*/
                        $("body").addClass("sidebar-collapse");
                        $("#tabledata, #tabledetail, #tablehdetail").each(function(){
                            $(this).removeClass("table-bordered").addClass("table-striped");
                        });
                    } else if ($.colSM()) { /*.col-sm*/
                        $("body").addClass("sidebar-collapse");
                        $("#tabledata, #tabledetail, #tablehdetail").each(function(){
                            $(this).removeClass("table-bordered").addClass("table-striped");
                        });
                    } else if ($.colMD()) { /*.col-md*/
                        $("body").addClass("sidebar-collapse");
                        $("#tabledata, #tabledetail, #tablehdetail").each(function(){
                            $(this).removeClass("table-bordered").addClass("table-striped");
                        });
                    } else { /*.col-lg*/
                        $("#tabledata, #tabledetail, #tablehdetail").each(function() {
                            $(this).removeClass("table-striped").addClass("table-bordered");
                        });
                    }
                };

                $(document).ajaxSend(function() {	 
                    $(".se-pre-con").show();
                }).ajaxStop(function() {	        
                    $(".se-pre-con").hide();	    
                }).ajaxError(function() {	        
                    $(".se-pre-con").hide();	    
                });
                
                $(this).mousemove(function (e) {
                    idleTime = 0;
                });
                
                $(this).keypress(function (e) {
                    idleTime = 0;
                });
                
                $(document).on("click", "#frmlogout button[name=btnyes]", function() {
                    window.location.href = "<?php echo base_url()."dashboard/signout";?>";
                });
                
                $(document).on("click", "#frmlogout button[name=btno]", function() {
                    sesi = 0;
                });
                
                var hWidth = parseInt($.docWidth()) - parseInt($(".dropdown-toggle").outerWidth(true)) - parseInt($(".dropdown-toggle").outerWidth(true));
                $(".navbar a.logo.hidden-lg").css({"width": hWidth, "background-color": "transparent", "display": "inline-block"});
                
                $("input[type=text]").on("keyup", function(event) {
                        // allow: backspace, delete, tab, escape, enter, space, home, end, left, right
                    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || event.keyCode == 32 || (event.keyCode >= 35 && event.keyCode <= 39) ||
                        // allow: |
                        (event.shiftKey && event.keyCode == 220) || 
                        // allow: : ;
                        (event.shiftKey && event.keyCode == 59) || event.keyCode == 59 || 
                        // allow: = +
                        event.keyCode == 61 || (event.shiftKey && event.keyCode == 61) || 
                        // allow: - _
                        event.keyCode == 173 || (event.shiftKey && event.keyCode == 173) || 
                        // allow: [ {
                        event.keyCode == 219 || (event.shiftKey && event.keyCode == 219) || 
                        // allow: ] }
                        event.keyCode == 221 ||  (event.shiftKey && event.keyCode == 221) || 
                        // allow: , .
                        (!event.shiftKey && event.keyCode == 188) || (!event.shiftKey && event.keyCode == 190) || event.keyCode == 191 || 
                        // allow: letter a - z / A - Z
                        (event.keyCode >= 65 && event.keyCode <= 122) || 
                        // allow: Ctrl+A
                        (event.keyCode == 65 && event.ctrlKey === true) || 
                        // allow: ! @ # $ % ^
                        (event.shiftKey && (event.keyCode >= 48 && event.keyCode <=54)) || 
                        // allow: * ( )
                        (event.shiftKey && (event.keyCode >= 56 && event.keyCode <=57))) 
                    {
                        // let it happen, don't do anything
                        return;
                    }
                    else 
                    {
                            // Ensure that it is a number and stop the keypress
                        if ( event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) 
                        {
                            //alert(event.keyCode);
                            event.preventDefault(); 
                        }   
                    }
                });
                
                $(document).on("keydown", ".numeric", function(e)
                {
                    // Allow: backspace, delete, tab, escape, and enter
                    if ( e.keyCode == 46 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 27 || e.keyCode == 13 || 
                         // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) || 
                         // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) 
                    {
                        // let it happen, don't do anything
                        return;
                    }
                    else 
                    {
                        // Ensure that it is a number and stop the keypress
                        if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 )) 
                        {
                            e.preventDefault(); 
                        }   
                    }
                });
                
                $(document).on("keyup", ".currency", function(e)
                {
                    var val = ($(this).val() != "" ? $.number($(this).val(), 0, "", ",") : "");
                        
                    $(this).val(val);
                    e.preventDefault();
                });
                
                $("#frmdialog").on("hidden.bs.modal", function() {
                    if ($(this).find(".btn").attr("data-focus") != "") {
                        $($(this).find(".btn").attr("data-focus")).focus();
                    }
                });
                
                $(document).on("click", ".sidebar-form button[name=btncari]", function(e)
                {
                    var formData = new FormData($("form")[0]);
                    
                    $.ajax({
                        type: "post",
                        dataType: "html",
                        url: "<?php echo base_url().'dashboard/pencarian';?>",
                        data: formData,
                        beforeSend: function(){
                            $(".content-wrapper").html("");
                        },
                        success: function(content) {
                            $(".content-wrapper").html(content);
                        },
                        contentType: false,
                        processData: false,
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.statusText);
                            alert(xhr.responseText);
                        }
                    });
                    e.preventDefault();
                });
                
                $(document).on("click", "#navbar-form button[name=btncari]", function(e)
                {
                    /*Allow: enter*/
                    var searchlink = $("#navbar-form").attr("action");
                    var formData = $("#navbar-form").serialize();
                        
                    $.ajax({
                        type: "post",
                        dataType: "html",
                        url: searchlink,
                        data: formData,
                        success: function(content) {
                            $(".table tbody").html(content);
                            $("#pagination").html( $("#paging").html() );
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.statusText);
                            alert(xhr.responseText);
                        }
                    });
                    e.preventDefault();
                });
                
                $(document).on("click", "a[title=Pratinjau]", function(e) 
                {
                    e.preventDefault();
                    var preview = $(this).attr("href");
                    
                    $.ajax({
                        type: "get",
                        dataType: "json",
                        url: preview,
                        success: function(data) 
                        {
                            var url = "<?php echo base_url();?>js/pdfjs/viewer.html?file=<?php echo base_url().'tmp/';?>" + data.filename;
                            var contentHtml = "<iframe src='"+ url + "' width='100%' height='459'></iframe>";
                            $("#frmpreview").find(".modal-dialog").css({"width": "858px", "margin-top": "50px"});
                            $("#frmpreview").removeClass().addClass("modal fade modal-success").modal("show")
                                .find(".modal-title").html("Pratinjau Data")
                                .parent().parent().find(".modal-body").html(contentHtml);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.statusText);
                            alert(xhr.responseText);
                        }
                    });
                });

                $(document).on("click", "a[title='Pratinjau Data']", function(e)
                {
                    e.preventDefault();
                    var title = $(this).attr("title");
                    var printlink = $(this).attr("href");
                    var contentHtml = "<iframe src='"+ printlink + "' width='100%' height='485'></iframe>";
                    
                    $("#frmpreview").find(".modal-dialog").css({"width": "780px", "margin-top": "50px"});
                    $("#frmpreview").removeClass().addClass("modal fade modal-success").modal("show")
                        .find(".modal-title").html(title)
                        .parent().parent().find(".modal-body").html(contentHtml);
                });
                
                $(document).on("click", "#frmpreview button[name=btnprint]", function() {
                    $("#frmpreview iframe").get(0).contentWindow.print();
                });
                
                $(document).on("click", "a[title='Baca Data']", function(e)
                {
                    var editlink = $(this).attr("href");
                    
                    $.ajax({
                        dataType: "html",
                        url: editlink,
                        beforeSend: function() {
                            $(".content-wrapper").html("");
                        },
                        success: function(content) {
                            $(".content-wrapper").html(content);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.statusText);
                            alert(xhr.responseText);
                        }
                    });
                    e.preventDefault();
                });
                
                $(document).on("click", "a[title='Aktif Data']", function(e)
                {
                    var activelink = $(this).attr("href");
                    var element = $(this);
                    
                    $.ajax({
                        dataType: "json",
                        url: activelink,
                        success: function(d) 
                        {
                            if (d.status == "Y")
                                element.removeClass('btn btn-danger').addClass('btn btn-success').find('i').removeClass('fa fa-close').addClass('fa fa-check');
                            else
                                element.removeClass('btn btn-success').addClass('btn btn-danger').find('i').removeClass('fa fa-check').addClass('fa fa-close');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.statusText);
                            alert(xhr.responseText);
                        }
                    });
                    e.preventDefault();
                });
                
                $(document).on("click", "a[title='Reset Data']", function(e)
                {
                    var resetlink = $(this).attr("href");
                        
                    $.ajax({
                        dataType: "json",
                        url: resetlink,
                        success: function(d) 
                        {
                            $("#frmdialog").removeClass().addClass("modal fade modal-warning").modal("show")
                                .find(".modal-title").html("Berhasil")
                                .parent().parent().find(".modal-body p").html("Katasandi berhasil diubah!.<br>Katasandi = Id Pengguna");
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.statusText);
                            alert(xhr.responseText);
                        }
                    });
                    e.preventDefault();
                });
                        
                $(document).on("click", "a[title='Ubah Data']", function(e)
                {
                    var editlink = $(this).attr("href");
                         
                    $.ajax({
                        dataType: "html",
                        url: editlink,
                        beforeSend: function() {
                            $(".content-wrapper").html("");
                        },
                        success: function(content) {
                            $(".content-wrapper").html(content);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.statusText);
                            alert(xhr.responseText);
                        }
                    });
                    e.preventDefault();
                });     
                
                $(document).on("click", "#tabledata tr", function(e)
                {
                    if ($.docWidth() < 767) 
                    {
                        var thisLink = $(this).attr("data-href");                    
                        if (thisLink != "")
                        {
                            $.ajax({
                                type: "post",
                                dataType: "html",
                                url: thisLink,
                                beforeSend: function() {
                                    $(".content-wrapper").html("");
                                },
                                success: function(content) {
                                    $(".content-wrapper").html(content);
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.statusText);
                                    alert(xhr.responseText);
                                }
                            });
                        }
                    }
                    e.preventDefault();
                });
        
                $(document).on("click", "a[title='Hapus Data']", function(e)
                {
                    var col = ($(this).attr("col") != null ? $(this).attr("col") : 2);
                    var nama = $(this).parent().parent().parent().children("td:eq("+col+")").text();
                    var delink = $(this).attr("href");
                    
                    $("#frmconfirm").removeClass().addClass("modal fade modal-danger").modal("show")
                        .find(".modal-title").html("Konfirmasi")
                        .parent().parent().find(".modal-body").html("Apakah anda yakin menghapus data ini:<br>`"+ nama +"`?")
                        .parent().parent().find(".modal-footer button[name=btnya]").attr("data-href", delink);
                    
                    e.preventDefault();
                });
                
                $(document).on("click", "#frmconfirm button[name=btnya]", function()
                {
                    $("#frmconfirm").modal("hide");
                    var delink = $(this).attr("data-href");
                    var targetlink = $(this).attr("data-target");
                    
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: delink,
                        success: function(d) 
                        {
                            /*console.log(JSON.stringify(d));*/
                            if (d.notif == "modal-success")
                            {
                                if ($.docWidth() < 767) 
                                {
                                    $.ajax({
                                        type: "post",
                                        dataType: "html",
                                        url: targetlink,
                                        beforeSend: function() {
                                            $(".content-wrapper").html("");
                                        },
                                        success: function(content) {
                                            $(".content-wrapper").html(content);
                                            
                                            $("#frmdialog").removeClass().addClass("modal fade "+d.notif).modal("show")
                                                .find(".modal-title").html(d.title)
                                                .parent().parent().find(".modal-body p").html("Data berhasil dihapus!")
                                                .parent().parent().find(".modal-footer button[name=btnclose]").attr("data-focus", d.elfocus);
                                        },
                                        error: function(xhr, ajaxOptions, thrownError) {
                                            alert(xhr.statusText);
                                            alert(xhr.responseText);
                                        }
                                    });
                                }
                                else
                                {
                                    $.get(d.messg, function(conten){
                                        $(".table tbody").html(conten);
                                        $("#pagination").html( $("#paging").html() );
                                    });
                                }
                            }
                            else
                            {
                                $("#frmdialog").removeClass().addClass("modal fade "+d.notif).modal("show")
                                    .find(".modal-title").html(d.title)
                                    .parent().parent().find(".modal-body p").html(d.messg)
                                    .parent().parent().find(".modal-footer button[name=btnclose]").attr("data-focus", d.elfocus);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.responseText);
                        }
                    });
                });
                
                $(document).on("click", "#mainpagination ul li a", function(e)
                {
                    var linkurl = $(this).attr("href");
                    if (linkurl != "#")
                    {
                        $.ajax({
                            dataType: "html",
                            url: linkurl,
                            success: function(conten) {
                                $(".todo-list").html(conten);
                                $("#mainpagination").html( $("#paging").html() );
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.statusText);
                                alert(xhr.responseText);
                            }
                        });
                    }
                    e.preventDefault();
                });
                
                $(document).on("click", "#pagination ul li a", function(e)
                {
                    var linkurl = $(this).attr("href");
                    if (linkurl != "#")
                    {
                        $.ajax({
                            dataType: "html",
                            url: linkurl,
                            success: function(conten) {
                                $(".table tbody").html(conten);
                                $("#pagination").html( $("#paging").html() );
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.statusText);
                                alert(xhr.responseText);
                            }
                        });
                    }
                    e.preventDefault();
                });
                
                $('.user-footer .pull-left').each(function()
                {
                    $(this).on("click", function(e)
                    {
                        if ($(this).attr('class') == 'shortcut disabled')
                        {
                            <?php if ($this->config->item('program_version') == 'demo'):?>
                                $("#frmpopup").modal("show")
                                    .find(".modal-title").html("Informasi")
                                    .parent().parent().find(".modal-body").html("<?php echo $this->config->item('site_blok');?>");
                            <?php endif;?>
                        }
                        else
                        {
                            var link = "<?php echo base_url()."dashboard/profile";?>";
                            $.ajax({
                                type: 'post',
                                dataType: 'html',
                                url: link,
                                beforeSend: function(){
                                    $('.content-wrapper').html('');
                                },
                                success: function(content) {
                                    $('.content-wrapper').html(content);
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.statusText);
                                    alert(xhr.responseText);
                                }
                            });
                        }
                        e.preventDefault();
                    });
                });
                
                $(document).on("click", ".sidebar-menu li.treeview a", function(e)
                {
                    var activeArrow = $(this).find(".pull-right-container i");
                    var lastArrow = $(this).parent().parent().find("li a .pull-right-container i");
                    
                    lastArrow.removeClass("fa fa-angle-down pull-right");
                    lastArrow.addClass("fa fa-angle-left pull-right");
                    
                    if (activeArrow.hasClass("fa-angle-left fa pull-right"))
                    {
                        activeArrow.removeClass("fa fa-angle-left pull-right");
                        activeArrow.addClass("fa fa-angle-down pull-right");
                    }
                    else
                    {
                        activeArrow.removeClass("fa fa-angle-down pull-right");
                        activeArrow.addClass("fa fa-angle-left pull-right");
                    }
                    e.preventDefault();
                });
                
                $(document).on("click", ".sidebar-menu li.treeview ul li a", function(e)
                {
                    var thisLink = $(this).attr("href");
                    var thisParent = $(this).parent();
                    var activeArrow = $(this).find(".pull-right-container i");
                    var lastArrow = $(this).parent().parent().find("li a .pull-right-container i");
                    
                    if ($(this).attr("class") == "disabled")
                    {
                        <?php if ($this->config->item('program_version') == 'demo'):?>
                            $("#frmPopup").modal("show")
                                .find(".modal-title").html("Informasi")
                                .parent().parent().find(".modal-body").html("<?php echo $this->config->item('site_blok');?>");
                        <?php endif;?>
                    }
                    else
                    {
                        if (thisLink == "#")
                        {
                            lastArrow.removeClass("fa fa-angle-down pull-right");
                            lastArrow.addClass("fa fa-angle-left pull-right");
                            
                            if (activeArrow.hasClass("fa-angle-left fa pull-right"))
                            {
                                activeArrow.removeClass("fa fa-angle-left pull-right");
                                activeArrow.addClass("fa fa-angle-down pull-right");
                            }
                            else
                            {
                                activeArrow.removeClass("fa fa-angle-down pull-right");
                                activeArrow.addClass("fa fa-angle-left pull-right");
                            }
                        }
                        else
                        {
                            $.ajax({
                                dataType: "html",
                                url: thisLink,
                                beforeSend: function(){
                                    thisParent.parent().find("li").removeClass("active");
                                    $(".content-wrapper").html("");
                                },
                                success: function(content) {
                                    thisParent.addClass("active");
                                    $(".content-wrapper").html(content);
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.statusText);
                                    alert(xhr.responseText);
                                }
                            });
                        }
                    }
                    e.preventDefault();
                });
                
                $(document).on("click", ".small-box a", function(e)
                {
                    var thisLink = $(this).attr("href");
                    $.ajax({
                        dataType: "html",
                        url: thisLink,
                        beforeSend: function(){
                            $(".content-wrapper").html("");
                        },
                        success: function(content) {
                            $(".content-wrapper").html(content);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.statusText);
                            alert(xhr.responseText);
                        }
                    });
                    e.preventDefault();
                });
                
                $.classTable();
                /*$("#screensize").html("[w: "+$.docWidth()+" h: "+$.docHeight()+"]");*/
            });
            
            $(window).resize(function() {
                $.classTable();
            });
        </script>
    </head>

    <body class="hold-transition skin-<?php echo $this->config->item('site_theme');?> sidebar-mini">
        <div class="se-pre-con"></div>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url().'dashboard';?>" class="logo hidden-xs">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-mini"><img style="margin:9px 0;" src="<?php echo base_url().'images/'.(getCompany()->logo != '-' ? getCompany()->logo : $this->config->item('site_icon'));?>" border="0" width="32" height="32"></span>
                    <span class="logo-lg"><img src="<?php echo base_url().'images/'.(getCompany()->logo != '-' ? getCompany()->logo : $this->config->item('site_icon'));?>" border="0" width="32" height="32"> <?php echo (getCompany()->alias != '-' ? getCompany()->alias : $this->config->item('site_smallname'));?></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <a href="<?php echo base_url().'dashboard';?>" class="logo hidden-xs" style="background-color:transparent;padding:0;text-align:none;width:auto;">
                        <span class="logo-mini" style="margin:unset;font-size:inherit"><?php echo (getCompany()->nama != '-' ? getCompany()->nama : strtoupper(strip_tags($this->config->item('site_longname')))).' <small style="font-size:65%">'.(getCompany()->moto != '-' ? getCompany()->moto : $this->config->item('site_version')).'</small>';?></span>
                        <span class="logo-lg"><?php echo (getCompany()->nama != '-' ? getCompany()->nama : strtoupper(strip_tags($this->config->item('site_longname')))).' <small style="font-size:65%">'.(getCompany()->moto != '-' ? getCompany()->moto : $this->config->item('site_version')).'</small>';?></span>
                    </a>
                    <a href="<?php echo base_url().'dashboard';?>" class="logo hidden-lg hidden-md hidden-sm">
                        <span class="logo-lg"><img src="<?php echo base_url().'images/'.$this->config->item('site_icon');?>" border="0" width="32" height="32"> <?php echo $this->config->item('site_smallname');?></span>
                    </a>
                    
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url().'arsip/photo/'.($this->session->userdata('SESS_USER_PHOTO') != '-' ? $this->session->userdata('SESS_USER_PHOTO') : 'nopicture.png');?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs">
                                        <?php echo $this->session->userdata('SESS_USER_NAME');?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo base_url().'arsip/photo/'.($this->session->userdata('SESS_USER_PHOTO') != '-' ? $this->session->userdata('SESS_USER_PHOTO') : 'nopicture.png');?>" class="img-circle" alt="User Image">
                                        <p><?php echo $this->session->userdata('SESS_USER_NAME');?><small>Member since Nov. 2012</small></p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo base_url().'dashboard/profile';?>" class="btn btn-default btn-flat"><i class="fa fa-user margin-r-5"></i>Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo base_url().'dashboard/signout';?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out margin-r-5"></i>Keluar</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>      
            <!--header end-->
            
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url().'arsip/photo/'.($this->session->userdata('SESS_USER_PHOTO') != '-' ? $this->session->userdata('SESS_USER_PHOTO') : 'nopicture.png');?>" alt="User Image" class="img-circle">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $this->session->userdata('SESS_USER_NAME');?> </p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            <span id="screensize"></span>
                        </div>
                    </div>
                    <!-- search form -->
                    <form class="sidebar-form" action="#" method="post">
                        <div class="input-group">
                            <input type="text" name="txtsearch" class="form-control" placeholder="Pencarian...">
                            <span class="input-group-btn">
                                <button type="submit" name="btncari" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MENU UTAMA</li>
                        <li class="active">
                            <a href="<?php echo base_url().'dashboard';?>">
                                <i class="fa fa-dashboard margin-r-5"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <?php foreach ($this->config->item('menu_sidebar') AS $menu):?>
                            <?php if ($menu['submenu'] == 0):?>
                                <li>
                                    <a href="<?php echo $menu['link'];?>">
                                        <i class="<?php echo $menu['logo'];?>"></i> <span><?php echo $menu['name'];?></span>
                                    </a>
                                </li>
                            <?php else:?>
                                <li class="treeview">
                                    <?php if (getAccess($this->session->userdata('SESS_USER_ID'), $menu['column'], 'read') == 'Y'):?>
                                        <a href="#">
                                            <i class="<?php echo $menu['logo'];?>"></i> <span><?php echo $menu['name'];?></span>
                                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                        </a>
                                    <?php else:?>
                                        <a href="#">
                                            <i class="<?php echo $menu['logo'];?>"></i> <span><?php echo $menu['name'];?></span>
                                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                        </a>
                                    <?php endif;?>
                                    <ul class="treeview-menu">
                                        <?php foreach ($menu['submenu'] as $submenu):?>
                                            <li>
                                                <?php if (getAccess($this->session->userdata('SESS_USER_ID'), $submenu['subcol'], 'read') == 'N' || ($this->config->item('program_version') == 'demo' && in_array($submenu['subname'], $this->config->item('menu_disable'))) ):?>
                                                    <?php if ($submenu['submenus'] == 0):?>
                                                        <a href="<?php echo $submenu['sublink'];?>" class="disabled"><i class="<?php echo $submenu['sublogo']; ?>"></i> <span><?php echo $submenu['subname']; ?></span></a>
                                                    <?php else:?>
                                                        <a href="#" class="disabled">
                                                            <i class="<?php echo $submenu['sublogo']; ?>"></i> <span><?php echo $submenu['subname']; ?></span>
                                                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                        </a>
                                                        <ul class="treeview-menu">
                                                            <?php foreach ($submenu['submenus'] as $subsubmenu):?>
                                                                <li>
                                                                    <a href="#" class="disabled"><i class="<?php echo $subsubmenu['sublogos']; ?>"></i> <span><?php echo $subsubmenu['subnames']; ?></span></a>
                                                                </li>
                                                            <?php endforeach;?>
                                                        </ul>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <?php if ($submenu['submenus'] == 0):?>
                                                        <a href="<?php echo $submenu['sublink'];?>"><i class="<?php echo $submenu['sublogo']; ?>"></i> <span><?php echo $submenu['subname']; ?></span></a>
                                                    <?php else:?>
                                                        <a href="#">
                                                            <i class="<?php echo $submenu['sublogo']; ?>"></i> <span><?php echo $submenu['subname'];?></span>
                                                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                        </a>
                                                        <ul class="treeview-menu">
                                                            <?php foreach ($submenu['submenus'] as $subsubmenu):?>
                                                                <li>
                                                                    <a href="<?php echo $subsubmenu['sublinks']; ?>"><i class="<?php echo $subsubmenu['sublogos']; ?>"></i> <span><?php echo $subsubmenu['subnames']; ?></span></a>
                                                                </li>
                                                            <?php endforeach;?>
                                                        </ul>
                                                    <?php endif;?>
                                                <?php endif;?>                                            
                                            </li>
                                        <?php endforeach;?>                                        
                                    </ul>
                                </li>
                            <?php endif;?>
                       <?php endforeach;?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
      
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <?php $this->load->view($content); ?>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- ./wrapper -->
        
        <footer class="main-footer">
            <div class="pull-right">
                <span class="hidden-xs"><?php echo $this->config->item('site_longname').' '.$this->config->item('site_version');?></span>
                <span id="screensize"></span>
            </div>
            <strong>Copyright &copy; <?php echo date("Y");?>.</strong> All rights reserved.
        </footer>
        
        <div id="frmpreview" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <i class="ion ion-information-circled"></i> <h4 class="modal-title">Confirm Modal</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button name="btnprint" type="button" class="btn btn-outline" data-href="#" data-target="#" style="width:75px;"><i class="fa fa-print"></i> Cetak</button>
                        <button name="btno" type="button" class="btn btn-outline" data-dismiss="modal" style="width:75px;"><i class="fa fa-remove"></i> Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->
        
        <div id="frmdialog" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <i class="ion ion-information-circled"></i> <h4 class="modal-title">Danger Modal</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button name="btnclose" type="button" class="btn btn-outline pull-right" data-dismiss="modal" data-focus="" data-notif="" data-number=""><i class="fa fa-remove"></i> Tutup</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        <div id="frmconfirm" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <i class="ion ion-information-circled"></i> <h4 class="modal-title">Confirm Modal</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button name="btnya" type="button" class="btn btn-outline" data-href="#" data-target="#" style="width:75px;"><i class="fa fa-check"></i> Ya</button>
                        <button name="btno" type="button" class="btn btn-outline" data-dismiss="modal" style="width:75px;"><i class="fa fa-remove"></i> Tidak</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->
        
        <div id="frmlogout" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <i class="ion ion-information-circled"></i> <h4 class="modal-title">Peringatan!</h4>
                    </div>
                    <div class="modal-body">
                        <p>Sesi anda telah habis!!,<br>Apakah anda ingin keluar dari sistem?</p>
                    </div>
                    <div class="modal-footer">
                        <button name="btnyes" type="button" class="btn btn-outline" data-href="#" data-target="#" style="width:75px;"><i class="fa fa-check margin-r-5"></i>Ya</button>
                        <button name="btno" type="button" class="btn btn-outline" data-dismiss="modal" style="width:75px;"><i class="fa fa-remove margin-r-5"></i>Tidak</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->
    </body>
</html>