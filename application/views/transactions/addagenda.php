<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed"); 
if (isset($datas) && $datas == true) 
{
	$id = ($datas->id != '-' ? $datas->id : set_value('txtid'));
    $date = ($datas->tanggal != '' ? $datas->tanggal : date('d-m-Y'));	
    $time = ($datas->waktu != '' ? $datas->waktu : date('H:m'));	
	$event = ($datas->kegiatan != '-' ? $datas->kegiatan : set_value('txtevent'));
    $note = ($datas->keterangan != '-' ? $datas->keterangan : set_value('txtnote'));
	$status = $datas->status;
} 
else 
{
	$id = set_value('txtid');
    $date = date('d-m-Y');
	$time = set_value('txtime');
    $event = set_value('txtevent');
	$note = set_value('txtnote');    
	$status = 'N';    
} ?>
<script type="text/javascript">    
	$(document).ready(function()
    {        
		$("#txtdate").datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });
        
        $("#txtime").timepicker({
            showInputs: false,
            showMeridian: false,
            defaultTime: false
        });
        
        $("button[name=btnsimpan]").on("click", function(e) 
        {
            $("input:text").removeAttr("disabled");
            var formData = new FormData($('form')[1]);
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo base_url();?>transactions/updateagenda",
                data: formData,
                success: function(d) 
                {
                    console.log(JSON.stringify(d));
                    $("input:hidden[name=lastcreated]").val(d.lastcreated);
                    
                    if (d.caption == "UBAH AGENDA")
                    {
                        $.ajax({
                            dataType: "html",
                            url: "<?php echo base_url();?>transactions/agenda/<?php echo $search;?>/<?php echo $page;?>",
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
                            $("input:text").val("");
                               
                            $('#txtnumber').empty();
                            $.each( d.datacode, function(n, item) {
                                $('#txtnumber').append( $("<option value='"+ item.format +"'>"+ item.format +"</option>") );
                            });
                            $("#txtdate, #txtmaildate").each(function() {
                                $(this).datepicker("update", new Date());
                            });
                            
                            savefile = new Array();
                            sumfile = savefile.length;
                            tablefile(savefile);
                        }
                        
                        $("#frmdinbox").removeClass().addClass("modal fade "+d.notif).modal("show")
                            .find(".modal-title").html(d.title)
                            .parent().parent().find(".modal-body p").html(d.messg)
                            .parent().parent().find(".modal-footer button[name=btnclose]").attr("data-focus", d.elfocus);
                        
                        if (d.notif == "modal-danger" && d.elfocus == "newcode"){
                            $("#txtnumber").empty().append("<option value='"+d.datacode+"'>"+d.datacode+"</option>").val(d.datacode);
                        }
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
                url: "<?php echo base_url();?>transactions/agenda/<?php echo $search?>/<?php echo $page?>",
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
        
        <?php if ($caption == "UBAH AGENDA"):?>
            <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'edit') == 'N'):?>
                $("input:text, select").each(function(){
                    $(this).attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
                });
                $("button[name=btnsimpan]").attr("disabled", true);
                $("button[name=btnbatal]").attr("disabled", true);
            <?php else:?>
                $("#txtcode").focus();
            <?php endif;?>
        <?php else:?>
            <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'new') == "N"):?>
                $("input:text, select").each(function(){
                    $(this).attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
                });
                $("button[name=btnsimpan]").attr("disabled", true);
                $("button[name=btnbatal]").attr("disabled", true);
            <?php else:?>
                $("#txtcode").focus();
            <?php endif;?>
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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-sticky-note-o"></i> <?php echo $caption?></h3>
                    <div class="box-tools pull-right">
                        <button name="btnbatal" type="reset" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                
                <form class="form-horizontal" role="form" method="post" action="#" enctype="multipart/form-data">
                    <div class="box-body">                    
                        <?php echo form_hidden("caption", $caption);
                        echo form_hidden("search", $search);
                        echo form_hidden("page", $page);
                        echo form_hidden("txtid", $id);?>
                        <div class="form-group">
                            <label for="txtdate" class="col-sm-3 control-label">Tanggal</label>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" id="txtdate" name="txtdate" value="<?php echo (isset($date) ? $date : null)?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtdate" class="col-sm-3 control-label">Waktu</label>
                            <div class="col-md-4">
                                <div class="bootstrap-timepicker">
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" id="txtime" name="txtime" value="<?php echo (isset($time) ? $time : null)?>">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtevent" class="col-sm-3 control-label">Kegiatan</label>
                            <div class="col-sm-9"><input class="form-control" type="text" id="txtevent" name="txtevent" value="<?php echo (isset($event) ? $event : null);?>"/></div>
                        </div>
                        <div class="form-group">
                            <label for="txtfrom" class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-9"><input class="form-control" type="text" id="txtnote" name="txtnote" value="<?php echo (isset($note) ? $note : null);?>"/></div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                        <button name="btnsimpan" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg"><i class="fa fa-save"></i><span class="inline-block margin-l-5 hidden-xs">Simpan</span></button>
                        <?php if($caption == 'UBAH AGENDA'):?>
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