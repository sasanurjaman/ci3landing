<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (isset($datas) && $datas != false)  
{
	/*tab data diri*/
    $id = ($datas->id != '' ? $datas->id : set_value('txtid'));
    $name = ($datas->judul != '' ? $datas->judul : set_value('txtname'));
    $file = ($datas->video != '' ? $datas->video : set_value('txtfile'));
} 
else 
{
	/*tab data diri*/
    $id = set_value('txtid');
    $name = set_value('txtname');
    $file = set_value('txtfile');
}?>
<script type="text/javascript">
    $(document).ready(function()
    {
		$("input:file").on("change", function(e) 
        {
            $("#txtfile").css("width", "auto");
            $("#txtfilename").css("display", "none");
        });
        
        $("button[name=btnsimpan]").on("click", function(e) 
        {
            $("input:text").removeAttr("disabled");
            var formData = new FormData($("form")[1]); 
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo base_url();?>transactions/updatevideo",
                data: formData,
                success: function(d) 
                {
                    console.log( JSON.stringify(d) );
                    if (d.caption == "UBAH VIDEO")
                    {
                        $.ajax({
                            type: "post",
                            dataType: "html",
                            url: "<?php echo base_url();?>transactions/video/<?php echo $search;?>/<?php echo $page;?>",
                            beforeSend: function() {
                                $(".content-wrapper").html("");
                            },
                            success: function(content) {
                                $(".content-wrapper").html(content);
                                
                                $("#frmdialog").removeClass().addClass("modal fade "+d.notif).modal("show")
                                    .find(".modal-title").html(d.title)
                                    .parent().parent().find(".modal-body p").html(d.messg)
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
                        if (d.notif == "modal-success")
                        {
                            $("input:text, #txtid").each(function() {
                                $(this).val("");
                            });
                        }
                        else
                        {
                            $(d.elfocus).keyup(function() {
                                if ($(this).val() != "")
                                    $(this).parent().parent().removeClass("has-error");
                            }).parent().parent().addClass("has-error");
                        }
                            
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
        
        $("button[name=btnbatal]").on("click", function() 
        {
            $.ajax({
                type: "post",
                dataType: "html",
                url: "<?php echo base_url();?>transactions/video",
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
        });
        
        <?php if ($caption == 'UBAH VIDEO'):?>
            <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T2', 'edit') == 'N'):?>
                $('input:text').each(function() {
                    $(this).attr('disabled', true).css({'background-color': '#EEEEEE', "color": "#6D6D6D", "font-style": "italic"});
                });
                $("input:submit[name=btnsimpan]").attr("disabled", true);
                $("input:reset[name=btnbatal]").focused();
            <?php else:?>
                $('#txtname').focused();
            <?php endif;?>
        <?php else:?>
            $("#txtname").focused();
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
        <div class="col-sm-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-video-camera"></i> <?php echo $caption?></h3>
                    <div class="box-tools pull-right">
                        <button name="btnbatal" type="reset" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" role="form" method="post" action="#" enctype="multipart/form-data">
                    <?php echo form_hidden('caption', $caption);
                    echo form_hidden('search', $search);
                    echo form_hidden('page', $page);
                    echo form_hidden('txtmp');
                    echo form_hidden('txtid', $id);?>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtname" class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9"><input class="form-control" type="text" id="txtname" name="txtname" value="<?php echo (isset($name) ? $name : null);?>"/></div>
                        </div>
                        <div class="form-group">
                            <label for="txtfile" class="col-sm-3 control-label">Berkas</label>
                            <div class="col-sm-9">
                                <?php if ($file == ''):?>
                                    <input type="file" id="txtfile" name="txtfile">
                                <?php else:?>
                                    <input type="file" id="txtfile" name="txtfile" style="display:inline-block;width:85px;">
                                    <span id="txtfilename"><?php echo $file;?></span>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button name="btnsimpan" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg"><i class="fa fa-save"></i><span class="inline-block margin-l-5 hidden-xs">Simpan</span></button>
                        <?php if($caption == 'UBAH VIDEO'):?>
                            <button name="btnhapus" type="button" class="btn btn-danger visible-btn-lg hidden-lg hidden-md hidden-sm"><i class="fa fa-trash"></i></button>
                        <?php endif;?>
                        <button name="btnbatal" type="reset" class="btn btn-default hidden-xs"><i class="fa fa-remove"></i><span class="hidden-xs"> Tutup</span></button>
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