<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$name = $this->session->userdata('SESS_USER_ID'); ?>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#txtdate1, #txtdate2").each(function() {
            $(this).datepicker({
                autoclose: true,
                format: "dd-mm-yyyy"
            });
        });
        
        $("button[name=btnlaporan]").on("click", function(e) 
        {
            var formData = new FormData($("form")[0]);
            
            $.ajax({
                type: "post",
                dataType: "html",
                url: "<?php echo base_url();?>index.php/reports/reportnews",
                data: formData,
                beforeSend: function() {
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
        
		$("button[name=btnbatal]").on("click", function() {
            $(".content-wrapper").html("");
        });
        
        <?php if ($this->sim_model->access($this->session->userdata('SESS_USER_ID'), 'T1', 'edit') == "N"):?>
			$("input:text").attr("disabled", true).css({"background-color": "#ECE9D8", "color": "#ACA899", "font-style": "italic"});
			$("button[name=btnsimpan]").attr("disabled", true);
            $("button[name=btnsimpan]").focus();
        <?php endif;?>
    });
</script>
<section class="content-header">
    <h1><?php echo $mainpage;?><small><?php echo $caption;?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="<?php echo $iconpage;?>"></i> <?php echo $mainpage;?></a></li>
        <?php if ($caption != ""):?>
            <li class="active"><?php echo $caption?></li>
        <?php endif?>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $caption?></h3>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" role="form" method="post" action="#" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtdate" class="col-sm-3 control-label">Tanggal</label>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control" id="txtdate1" name="txtdate1" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control" id="txtdate2" name="txtdate2" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button name="btnlaporan" type="submit" class="btn btn-primary">Laporan</button>
                        <button name="btnbatal" type="reset" class="btn btn-default">Batal</button>
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