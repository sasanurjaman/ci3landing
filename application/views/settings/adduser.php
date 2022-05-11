<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (isset($datas) && $datas != false)  
{
	$id = ($datas->id != '-' ? $datas->id : set_value('txtid'));
	$userid = ($datas->userid != '-' ? $datas->userid : set_value('txtuserid'));
	$name = ($datas->nama != '-' ? $datas->nama : set_value('txtname'));
	$level = ($datas->level != '-' ? $datas->level : 'User');
	$active = ($datas->aktif == 'Y' ? $datas->aktif : 'N');
	$foto = ($datas->foto != '-' ? base_url().'arsip/photo/'.$datas->foto : base_url().'arsip/photo/nopicture.png');
} 
else 
{
	$id = set_value('txtid');
	$userid = set_value('txtuserid');
	$name = set_value('txtname');
	$level = set_value('txtlevel');
	$active = 'N';	
    $foto = base_url().'arsip/photo/nopicture.png';
} ?>
<script type="text/javascript">
    $(function() {
        /*iCheck for checkbox and radio inputs*/
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
    
    $(document).ready(function()
    {
		$(".select2").select2();
        
        $(document).on("change", "#txtfile", function(e) 
        {
            var formData = new FormData($('form')[1]); 
            
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '<?php echo base_url();?>settings/uploadtmp',
                data: formData,
                success: function(d) 
                {
                    console.log( JSON.stringify(d) );
                    if (d.notif == 'modal-success')
                    {
                        var html = '<img src="<?php echo base_url();?>tmp/'+d.filename+'" width="122" height="122">';
                        
                        $('.preview').html(html);
                        $('input:hidden[name=txtmp]').val( d.filename );
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
                    alert(xhr.statusText);
                    alert(xhr.responseText);
                }
            });
            e.preventDefault();
        });
        
        $("button[name=btnsimpan]").on("click", function(e) 
        {
            $("input:text").removeAttr("disabled");
            var formData = new FormData($("form")[1]); 
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo base_url();?>settings/updateuser",
                data: formData,
                success: function(d) 
                {
                    /*console.log( JSON.stringify(d) );*/
                    if (d.caption == "UBAH PENGGUNA")
                    {
                        $.ajax({
                            type: "post",
                            dataType: "html",
                            url: "<?php echo base_url();?>settings/user/<?php echo $search;?>/<?php echo $page;?>",
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
                            $("input:text, input:file, input:hidden").each(function() {
                                $(this).val("");
                            });
                            $("input:checkbox").iCheck('uncheck');
                            $(".preview").html("<img src='<?php echo base_url()."arsip/photo/nopicture.png";?>' width='128' height='128'>");                            
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
        
        $("button[name=btnhapus]").on("click", function(e) 
        {
            var delink = "<?php echo base_url();?>settings/deluser/<?php echo $search;?>/<?php echo $page;?>/<?php echo $userid?>";
            var targetlink = "<?php echo base_url();?>settings/user/<?php echo $search;?>/<?php echo $page;?>";
                    
            $("#frmconfirm").removeClass().addClass("modal fade modal-danger").modal("show")
                .find(".modal-title").html("Konfirmasi")
                .parent().parent().find(".modal-body").html("Apakah anda yakin menghapus data ini:<br>`<?php echo $userid?>`?")
                .parent().parent().find(".modal-footer button[name=btnya]").attr("data-href", delink).attr("data-target", targetlink);
            e.preventDefault();        
        });
        
        $('button[name=btnbatal]').on('click', function() 
        {
            $.ajax({
                type: "post",
                dataType: "html",
                url: "<?php echo base_url();?>settings/user/<?php echo $search;?>/<?php echo $page;?>",
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
        
        if ($.colXS()) {
            $("#colxs12").html("<input class='form-control no-padding' type='file' id='txtfile' name='txtfile'/><span id='txtfilename'></span>");
        } else {
            $("#colsm5").html("<input class='form-control no-padding' type='file' id='txtfile' name='txtfile'/><span id='txtfilename'></span>");
        }
        
        $(".preview").html("<img src='<?php echo $foto;?>' width='122' height='122'>");
        <?php if (basename($foto) == "nopicture.png"):?>
            $("#txtfilename").html("");
        <?php else:?>
            $("#txtfilename").html("<?php echo basename($foto);?>");
        <?php endif;?>
        
        <?php if ($caption == 'UBAH PENGGUNA'):?>
            <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'delete') == 'N'):?>
                $("button[name=btnhapus]").attr("disabled", true);
            <?php endif;?>
            <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'N'):?>
                $("input:text, input:file, select").attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
                $("input:checkbox").iCheck("disable");
                $("button[name=btnsimpan]").attr("disabled", true);
                $("button[name=btnbatal]").focused();
            <?php else:?>
                $("#txtuserid").attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
                $("#txtname").focused();
            <?php endif;?>
        <?php else:?>
            $("#txtuserid").select();
        <?php endif;?>
    });
</script>
<section class="content-header">
    <h1><?php echo $mainpage;?><small><?php echo $caption;?></small></h1>
    <ol class="breadcrumb hidden-md hidden-sm hidden-xs">
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
                    <h3 class="box-title"><i class="fa fa-user"></i> <?php echo $caption?></h3>
                    <div class="box-tools pull-right">
                        <button name="btnbatal" type="reset" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                
                <form class="form-horizontal" role="form" method="post" action="#" enctype="multipart/form-data">
                    <?php echo form_hidden('caption', $caption);
                    echo form_hidden('page', $page);
                    echo form_hidden('search', $search);
                    echo form_hidden('txtmp');
                    echo form_hidden('txtid', $id);?>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtuserid" class="col-sm-3 control-label">ID Pengguna</label>
                            <div class="col-sm-9"><input class="form-control" name="txtuserid" type="text" id="txtuserid" value="<?php echo (isset($userid) ? $userid : null);?>"/></div>
                        </div>
                        <div class="form-group">
                            <label for="txtusername" class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9"><input class="form-control" name="txtname" type="text" id="txtname" value="<?php echo (isset($name) ? $name : null);?>"/></div>
                        </div>
                        <div class="form-group">
                            <label for="txtlevel" class="col-sm-3 control-label">Level</label>
                            <div class="col-sm-5 col-xs-12"><select class="form-control select2" name="txtlevel" id="txtlevel">
                                <option value="User" <?php echo ($level == "User" ? "SELECTED" : null);?>>User</option>
                                <option value="Admin" <?php echo ($level == "Admin" ? "SELECTED" : null);?>>Admin</option>
                            </select></div>
                            <div class="col-sm-4 hidden-xs">
                                <div class="preview" style="position:absolute;"><span>128 x 128px</span></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtactive" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-5">
                                <input type="checkbox" class="minimal" id="txtactive" name="txtactive" <?php echo ($active == "Y" ? "CHECKED" : null);?> value="Y"><span style="display:inline-block;position:relative;top:2px;left:5px;">Aktif</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtfile" class="col-sm-3 control-label">Foto</label>
                            <div class="col-sm-12 hidden-lg hidden-md hidden-sm">
                                <div class="preview"><span>128 x 128px</span></div>
                            </div>
                            <div id="colsm5" class="col-sm-5"></div>
                        </div>
                        <div class="form-group hidden-lg hidden-md hidden-sm">
                            <label for="txtfile" class="col-xs-12 control-label">Foto</label>
                            <div id="colxs12" class="col-xs-12"></div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button name="btnsimpan" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg"><i class="fa fa-save"></i><span class="inline-block margin-l-5 hidden-xs">Simpan</span></button>
                        <?php if($caption == 'UBAH PENGGUNA'):?>
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