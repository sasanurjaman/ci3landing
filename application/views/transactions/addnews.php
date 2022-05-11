<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (isset($datas) && $datas != false) 
{
	$id = ($datas->id != '-' ? $datas->id : set_value('txtid'));
	$date = ($datas->tanggal != '00-00-0000' ? $datas->tanggal : set_value('txtdate'));
	$title = ($datas->judul != '-' ? $datas->judul : set_value('txtcode'));
	$conten = ($datas->isi != '-' ? $datas->isi : set_value('txtname'));
	$eod = ($datas->akhir != '00-00-0000' ? $datas->akhir : set_value('txteod'));
} 
else 
{
	$id = set_value('txtid');
	$date = set_value('txtdate');
	$title = set_value('txtitle');
	$conten = set_value('txtconten');
	$eod = set_value('txteod');
}?>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("button[name=btnsimpan]").on("click", function(e) 
        {
            $("input:text").removeAttr("disabled");
            var formData = new FormData($("form")[1]); 
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo base_url();?>transactions/updatenews",
                data: formData,
                success: function(d) 
                {
                    console.log( JSON.stringify(d) );
                    if (d.caption == "UBAH BERITA")
                    {
                        $.ajax({
                            type: "post",
                            dataType: "html",
                            url: "<?php echo base_url();?>transactions/news/<?php echo $search;?>/<?php echo $page;?>",
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
                url: "<?php echo base_url();?>transactions/news",
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
        
        $("#txtcode").css("text-align", "center");
        
        <?php if ($caption == 'UBAH BERITA'):?>
            <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T1', 'edit') == 'N'):?>
                $("input:text").each(function() {
                    $(this).attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
                });
                $("input:submit[name=btnsimpan]").attr("disabled", true);
                $("input:reset[name=btnbatal]").focused();
            <?php else:?>
                $('#txtcode').attr("disabled", true).css({'background-color': '#EEEEEE', "color": "#6D6D6D", "font-style": "italic"});
                $('#txtname').focused();
            <?php endif;?>
        <?php else:?>
            $("#txtcode").focused();
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
                    <h3 class="box-title"><i class="fa fa-newspaper-o"></i> <?php echo $caption?></h3>
                    <div class="box-tools pull-right">
                        <button name="btnbatal" type="reset" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" role="form" method="post" action="#">
                    <?php echo form_hidden('caption', $caption);
                    echo form_hidden('search', $search);
                    echo form_hidden('page', $page);
                    echo form_hidden('txtid', $id);?>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtitle" class="col-sm-3 control-label">Judul</label>
                            <div class="col-sm-9"><input class="form-control" type="text" id="txtitle" name="txtitle" value="<?php echo (isset($title) ? $title : null);?>"/></div>
                        </div>
                        <div class="form-group">
                            <label for="txtconten" class="col-sm-3 control-label">Isi</label>
                            <div class="col-sm-9"><textarea class="form-control" id="txconten" name="txtconten"><?php echo (isset($conten) ? $conten : null);?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label for="txtdate" class="col-sm-3 control-label">Berakhir</label>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" id="txtdate" name="txtdate" value="<?php echo (isset($eod) ? $eod : null)?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button name="btnsimpan" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg"><i class="fa fa-save"></i><span class="inline-block margin-l-5 hidden-xs">Simpan</span></button>
                        <?php if($caption == 'UBAH BERITA'):?>
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