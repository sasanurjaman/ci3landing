<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="<?php echo strip_tags($this->config->item('site_name').", ".$this->config->item('site_smallname').", ".$this->config->item('site_longname')." ".$this->config->item('site_version'));?>">
        <meta name="author" content="<?php echo $this->config->item('site_author');?>">
        <meta name="keywords" content="<?php echo strip_tags($this->config->item('site_smallname').' '.$this->config->item('site_longname'));?>" />
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
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>css/style.css" />
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery 2.2.3 -->
        <script src="<?php echo base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>
        <script type="text/javascript">
            $(function () 
            {
                $('input').iCheck({
                  checkboxClass: 'icheckbox_square-blue',
                  radioClass: 'iradio_square-blue',
                  increaseArea: '20%' // optional
                });
            });
            
            $(window).load(function() {
                $(".se-pre-con").fadeOut("slow");
            });
            
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
                
                $(document).ajaxSend(function() {	        
                    $(".se-pre-con").show();
                }).ajaxStop(function() {	        
                    $(".se-pre-con").hide();	    
                }).ajaxError(function() {	        
                    $(".se-pre-con").hide();	    
                });
                
                $("#frmdialog").on("hidden.bs.modal", function() {
                    if ($(this).find(".btn").attr("data-focus") != "") {
                        $($(this).find(".btn").attr("data-focus")).focus();
                    }
                });
                
                $("#frmlogin button[name=btnlogin]").click(function(e) 
                {
                    var formData = new FormData($("form")[0]);
                    
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: "<?php echo base_url();?>adminweb/do_login",
                        data: formData,
                        success: function(d) 
                        {
                            console.log(JSON.stringify(d));
                            if (d.notif == 'modal-success')
                            {
                                $('input:text').val("");
                                $('input:checked').prop("checked", false);
                                window.location.href = d.dashboardlink;
                            }
                            else
                            {
                                $(d.elfocus).keyup(function() {
                                    if ($(this).val() != "")
                                        $(this).parent().removeClass("has-error");
                                }).parent().addClass("has-error");
                                
                                $("#frmdialog").removeClass().addClass("modal fade "+d.notif).modal("show")
                                    .find(".modal-title").html(d.title)
                                    .parent().parent().find(".modal-body p").html(d.messg)
                                    .parent().parent().find(".modal-footer button[name=btnclose]").attr("data-focus", d.elfocus);
                            }
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
            });
        </script>
    </head>

    <body class="hold-transition login-page">
        <div class="se-pre-con"></div>
        <?php if ($activation == 'Y'):?>
            <br>
            <div class="row">
                <div class="col-sm-1">&nbsp;</div>
                <div class="col-sm-10">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Aktivasi Berhasil!</h4>
                        Demo pengguna berhasil diaktivasi!, Silakan login...
                    </div>
                </div>
                <div class="col-sm-1">&nbsp;</div>
            </div>
        <?php endif;?>
        <div class="login-box">
            <div class="login-box-body">
                <div style="margin-top:-77px; margin-bottom:10px; text-align:center;">
                    <img src="<?php echo base_url().'images/'.$this->config->item('site_logo');?>" width="100" height="100">
                    <div><?php echo $this->config->item('site_longname');?></div>
                </div>                 
                <p class="login-box-msg">Masukan Nama pengguna dan Katasandi</p>

                <form id="frmlogin" action="#" method="post">
                    <div class="form-group has-feedback">
                        <input id="txtusername" name="txtusername" type="text" class="form-control" placeholder="Nama pengguna" value="<?php echo (isset($username)?$username:null);?>">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="txtpassword" name="txtpassword" type="password" class="form-control" placeholder="Katasandi">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <div class="checkbox icheck">
                                <label><input type="checkbox"> Ingat Saya</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-5">
                            <button name="btnlogin" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg pull-right"><i class="fa fa-sign-in margin-r-5"></i>Masuk</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <?php if ($this->config->item('program_version') == 'live'):?>
                    <br>
                    <div class="row">
                        <div class="col-xs-12">
                            <span class="btn bg-<?php echo $this->config->item('site_theme');?> btn-block btn-flat">Nama pengguna: demo&nbsp;&nbsp;&nbsp;&nbsp;Katasandi: demo</span>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <!-- /.login-box-body -->
            <div class="login-note">
                <div><?php echo $this->config->item('site_name').' '.$this->config->item('site_version');?></div>
            </div>
            <!-- /.login-note -->
        </div>
        <!-- /.login-box -->
        
        <div id="frmdialog" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <i class="fa fa-info-circle margin-r-5"></i><h4 class="modal-title">Danger Modal</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button name="btnclose" type="button" class="btn btn-outline pull-right" data-dismiss="modal" data-focus=""><i class="fa fa-remove margin-r-5"></i>Tutup</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
            
    </body>
</html>