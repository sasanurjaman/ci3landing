<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (isset($datas) && $datas != false) 
{
	$id = ($datas->id != "-" ? $datas->id : set_value('txtid'));
	$format = ($datas->format != '' ? $datas->format : set_value('txtformat'));
    $size = ($datas->ukuran != '' ? $datas->ukuran : set_value('txtsize'));
    $paper = ($datas->kertas != '-' ? $datas->kertas : set_value('txtpaper'));
    $orient = ($datas->orentasi != '-' ? $datas->orentasi : set_value('txtorient'));
    $margins = ($datas->margin != '-' ? explode('|', $datas->margin) : set_value('txtmargins'));
    $top = ($datas->margin != '-' ? $margins[0] : set_value('txtop'));
    $bottom = ($datas->margin != '-' ? $margins[1] : set_value('txtbottom'));
    $left = ($datas->margin != '-' ? $margins[2] : set_value('txtleft'));
    $right = ($datas->margin != '-' ? $margins[3] : set_value('txtright'));    
} 
else 
{
	$id = set_value('txtid');
	$format = set_value('txtformat');
	$size = set_value('txtsize');
	$paper = set_value('txtpaper');
	$orient = set_value('txtorient');
	$top = set_value('txtop');
	$bottom = set_value('txtbottom');
	$left = set_value('txtleft');
	$right = set_value('txtright');
} ?>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        
        $("#txtfile").on("change", function(e) 
        {
            var formData = new FormData($("form")[1]); 
            /*console.log(formData.toSource());*/
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo base_url();?>settings/uploadtmp",
                data: formData,
                success: function(d)
                {
                    console.log( JSON.stringify(d) );
                    if (d.notif == "modal-success")
                    {
                        var imghtml = "<img src='<?php echo base_url();?>tmp/"+d.filename+"' style='width:100%;height:100%;'>";
                        
                        $(".preview").html(imghtml);
                        $("input:hidden[name=txtmp]").val(d.filename);
                    }
                    else
                    {
                        $("#frmdialog").removeClass().addClass("modal fade "+d.notif).modal("show")
                            .find(".modal-title").html(d.title)
                            .parent().parent().find(".modal-body p").html(d.messg)
                            .parent().parent().find(".modal-footer button[name=btnclose]").attr("data-focus", d.elfocus);
                    }
                },
                contentType: false,
                processData: false,
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.statusText);
                    console.log(xhr.responseText);
                }
            });
            e.preventDefault();
        });

        $("button[name=btnsimpan]").on("click", function(e) 
        {
            var formData = new FormData($("form")[1]);  
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '<?php echo base_url();?>settings/updateapplication',
                data: formData,
                success: function(d) 
                {
                    console.log( JSON.stringify(d) );
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
        
        $("#txtsize, #txtppn, #txtcount2, #txtcount3, #txtcount4, #txtop, #txtbottom, #txtleft, #txtright").each(function() {
            $(this).css("text-align", "center");
        });
        
        <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S5', 'edit') == 'N'):?>
			$("input:text").attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
			$("button[name=btnsimpan]").attr("disabled", true);
            $("button[name=btnbatal]").focus();
		<?php else:?>
            $("#txtpaper").val("<?php echo $paper;?>").trigger("change");
            $("#txtorient").val("<?php echo $orient;?>").trigger("change");
            $("#txtformat").focused();
        <?php endif;?>		
    });
</script>
<section class="content-header">
    <h1><?php echo $mainpage;?><small><?php echo $caption;?></small></h1>
    <ol class="breadcrumb hidden-lg hidden-md hidden-sm">
        <li><a href="#"><i class="<?php echo $iconpage;?>"></i> <?php echo $mainpage;?></a></li>
        <?php if ($caption != ""):?>
            <li class="active"><?php echo $caption?></li>
        <?php endif?>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-8 col-sm-8">
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-tags"></i> <?php echo $caption?></h3>
                    <div class="box-tools pull-right">
                        <button name="btnbatal" type="reset" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                
                <form class="form-horizontal" role="form" method="post" action="#" enctype="multipart/form-data">
                    <input type="hidden" id="txtmp" name="txtmp" value="">
                    <div class="box-body">
                        <div class="nav-tabs-custom tab-<?php echo $this->config->item('site_theme');?>">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-gears margin-r-5"></i>Lain-Lain</a></li>
                                <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-database margin-r-5"></i>Database</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="tab-1">
                                    <fieldset><legend>Upload</legend>
                                        <div class="form-group">
                                            <label for="txtformat" class="col-sm-3 control-label">Format</label>
                                            <div class="col-sm-9"><input class="form-control" type="text" id="txtformat" name="txtformat" value="<?php echo $format;?>" /></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtsize" class="col-sm-3 control-label">Ukuran</label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="txtsize" name="txtsize" value="<?php echo $size;?>" />
                                                    <div class="input-group-addon"><strong>KB</strong></div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset><legend>Cetak</legend>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="txtfile" class="col-sm-3 control-label">Logo</label>
                                                <div class="col-sm-9"><input class="form-control no-padding" type="file" name="txtfile" id="txtfile"/></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtpaper" class="col-sm-3 control-label">Kertas</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control select2" name="txtpaper" id="txtpaper">
                                                        <?php foreach($this->config->item('print_paper') AS $papers):?>
                                                            <option value="<?php echo $papers;?>"><?php echo $papers;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="preview" style="position:absolute;width:98px;height:82px">&nbsp;</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtorient" class="col-sm-3 control-label">Orentasi</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control select2" name="txtorient" id="txtorient">
                                                        <?php foreach($this->config->item('print_orient') AS $orients):?>
                                                            <option value="<?php echo $orients;?>"><?php echo $orients;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="txtmargin" class="col-sm-12 control-label" style="text-align:left">Batas Halaman (cm)</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtop" class="col-sm-3 control-label">Atas</label>
                                                <div class="col-sm-3"><input class="form-control no-padding" type="text" name="txtop" id="txtop" value="<?php echo (isset($top)?$top:null);?>"/></div>
                                                <label for="txtbottom" class="col-sm-3 control-label">Bawah</label>
                                                <div class="col-sm-3"><input class="form-control no-padding" type="text" name="txtbottom" id="txtbottom" value="<?php echo (isset($bottom)?$bottom:null);?>"/></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtleft" class="col-sm-3 control-label">Kiri</label>
                                                <div class="col-sm-3"><input class="form-control no-padding" type="text" name="txtleft" id="txtleft" value="<?php echo (isset($left)?$left:null);?>"/></div>
                                                <label for="txtright" class="col-sm-3 control-label">Kanan</label>
                                                <div class="col-sm-3"><input class="form-control no-padding" type="text" name="txtright" id="txtright" value="<?php echo (isset($right)?$right:null);?>"/></div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <fieldset><legend>Backup</legend>
                                        <center><button name="btnbackup" type="button" class="btn btn-danger">Backup Database</button></center>
                                    </fieldset>
                                    <fieldset><legend>Restore</legend>
                                        <div class="form-group">
                                            <label for="txtrestore" class="col-sm-3 control-label">Berkas</label>
                                            <div class="col-sm-7">
                                                <input class="form-control no-padding" type="file" id="txtrestore" name="txtrestore"/>
                                                <span id="txtfilename"></span>
                                            </div>
                                            <div class="col-sm-2"><button name="btngo" type="button" class="btn btn-danger">Go</button></div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
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
        <!-- /.col-xs-12 -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->