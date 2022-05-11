<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("button[name=btnsimpan]").on("click", function(e) 
        {
            $("input:text").removeAttr("disabled");
            var formData = new FormData($('form')[1]);
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo base_url();?>settings/updatepassword",
                data: formData,
                success: function(d) 
                {
                    console.log( JSON.stringify(d) );
                    $("#txtname").attr("disabled", true);
                    
                    if (d.notif == "modal-success")
                    {
                        $("input:password").each(function() {
                            $(this).val("");
                        });
                    }
                        
                    $("#frmdialog").removeClass().addClass("modal fade "+d.notif).modal("show")
                        .find(".modal-title").html(d.title)
                        .parent().parent().find(".modal-body p").html(d.messg)
                        .parent().parent().find(".modal-footer button[name=btnclose]").attr("data-focus", d.elfocus);
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
        
		$("button[name=btnbatal]").on("click", function() {
            $(".content-wrapper").html("");
        });
        
        <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S3', 'edit') == 'N'):?>
			$("input:text, input:password").each(function() {
				$(this).attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
			});
			$("button[name=btnsimpan]").attr("disabled", true);
            $("button[name=btnsimpan]").focus();
        <?php else:?>
            $("#txtname").attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
            $("#txtpassword").focus();
		<?php endif;?>
    });
</script>
<section class="content-header">
    <h1><?php echo $mainpage;?><small><?php echo $caption;?></small></h1>
    <ol class="breadcrumb hidden-xs">
        <li><a href="#"><i class="<?php echo $iconpage;?>"></i> <?php echo $mainpage;?></a></li>
        <?php if ($caption != ""):?>
            <li class="active"><?php echo $caption?></li>
        <?php endif?>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-6 col-sm-7">
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-lock"></i> <?php echo $caption?></h3>
                    <div class="box-tools pull-right">
                        <button name="btnbatal" type="reset" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                
                <form class="form-horizontal" role="form" method="post" action="#" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtname" class="col-sm-3 control-label">Pengguna</label>
                            <div class="col-sm-9"><input class="form-control" name="txtname" type="text" id="txtname" value="<?php echo $this->session->userdata('SESS_USER_NAME');?>"/></div>
                        </div>
                        <div class="form-group">
                            <label for="txtpassword" class="col-sm-3 control-label">KataSandiBaru</label>
                            <div class="col-sm-9"><input class="form-control" name="txtpassword" type="password" id="txtpassword" value=""/></div>
                        </div>
                        <div class="form-group">
                            <label for="txtrepassword" class="col-sm-3 control-label">UlangKataSandi</label>
                            <div class="col-sm-9"><input class="form-control" name="txtrepassword" type="password" id="txtrepassword" value=""/></div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                        <button name="btnsimpan" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg"><i class="fa fa-save"></i><span class="hidden-xs"> Simpan</span></button>
                        <button name="btnbatal" type="reset" class="btn btn-default hidden-xs"><i class="fa fa-remove"></i> Batal</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>