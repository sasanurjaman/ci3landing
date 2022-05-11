<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (isset($datas) && $datas != false) 
{
	$id = ($datas->id != "-" ? $datas->id : set_value("txtid"));
	$name = ($datas->nama != "-" ? $datas->nama : set_value("txtname"));
	$moto = ($datas->moto != "-" ? $datas->moto : set_value("txtmoto"));
	$address = ($datas->alamat != "-" ? $datas->alamat : set_value("txtaddress"));
	$city = ($datas->kota != "-" ? $datas->kota : set_value("txtcity"));
	$poscode = ($datas->kodepos != "-" ? $datas->kodepos : set_value("txtposcode"));
    $phone = ($datas->telepon != "-" ? $datas->telepon : set_value("txtphone"));
    $fax = ($datas->fax != "-" ? $datas->fax : set_value("txtfax"));
    $email = ($datas->email != "-" ? $datas->email : set_value("txtemail"));
	$logo = ($datas->logo != "-" ? base_url()."images/".$datas->logo : $this->config->item("site_logo"));
} 
else 
{
	$id = set_value("txtid");
	$name = set_value("txtname");
	$moto = set_value("txtmoto");
	$address = set_value("txtaddress");
	$city = set_value("txtcity");
	$poscode = set_value("txtposcode");
    $phone = set_value("txtphone");
    $fax = set_value("txtfax");
    $email = set_value("txtemail");
	$logo = $this->config->item("site_logo");
} ?>

<script type="text/javascript">
    $(document).ready(function()
    {
		$("input:file").on("change", function(e) 
        {
            var formData = new FormData($("form")[1]); 
            console.log(formData.toSource());
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
                        var imghtml = "<img src='<?php echo base_url();?>tmp/"+d.filename+"' width='197' height='197'>";
                        
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
        
        $("button[name=btnbatal]").on("click", function() {
            $(".content-wrapper").html("");
        });
                
        $("button[name=btnsimpan]").on("click", function(e) 
        {
            var formData = new FormData($("form")[1]); 
            
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '<?php echo base_url();?>settings/updatecompany',
                data: formData,
                success: function(d) 
                {
                    /*console.log( JSON.stringify(d) );*/
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
        
        <?php if (basename($logo) != "logo.png"):?>
            $(".preview").html("<img src='<?php echo $logo;?>' width='197' height='197'>");
            $("#txtfilename").html("<?php echo basename($logo);?>");
        <?php else:?>
            $(".preview").html("<img src='<?php echo $logo;?>' width='197' height='197'>");
            $("#txtfilename").html("");
        <?php endif;?>
            
        <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S1', 'edit') != 'Y'):?>
			$("input:text, input:file").each(function() {
				$(this).attr("disabled", true);
			});
			$("button[name=btnsimpan]").attr("disabled", true);
            $("button[name=btnbatal]").focus();
        <?php else:?>
            $("#txtname").focused();
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
        <div class="col-md-12">
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-building"></i> <?php echo $caption?></h3>
                    <div class="box-tools pull-right">
                        <button name="btnbatal" type="reset" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                
                <form class="form-horizontal" role="form" action="#" method="post" enctype="multipart/form-data">
                    <div class="row">                    
                        <div class="col-md-6">                        
                            <div class="box-body">
                                <?php echo form_hidden("txtid", $id);
                                echo form_hidden("txtmp"); ?>
                                <div class="form-group">
                                    <label for="txtname" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-9"><input class="form-control" type="text" id="txtname" name="txtname" value="<?php echo $name;?>" /></div>
                                </div>
                                <div class="form-group">
                                    <label for="txtmoto" class="col-sm-3 control-label">Slogan</label>
                                    <div class="col-sm-9"><input class="form-control" type="text" id="txtmoto" name="txtmoto" value="<?php echo $moto;?>"/></div>
                                </div>
                                <div class="form-group">
                                    <label for="txtaddress" class="col-sm-3 control-label">Alamat</label>
                                    <div class="col-sm-9"><input class="form-control" name="txtaddress" type="text" id="txtaddress" value="<?php echo $address;?>"/></div>
                                </div>
                                <div class="form-group">
                                    <label for="txtcity" class="col-sm-3 col-xs-12 control-label">Kota/Kodepos</label>
                                    <div class="col-sm-6 col-xs-8"><input class="form-control" name="txtcity" type="text" id="txtcity" value="<?php echo $city;?>"/></div>
                                    <div class="col-sm-3 col-xs-4"><input class="form-control text-center" name="txtposcode" type="text" id="txtposcode" value="<?php echo $poscode;?>"/></div>
                                </div>
                                <div class="form-group">
                                    <label for="txtphone" class="col-sm-3 col-xs-12 control-label">Telepon/Fax</label>
                                    <div class="col-sm-5 col-xs-6"><input class="form-control" name="txtphone" type="text" id="txtphone" value="<?php echo $phone;?>"/></div>
                                    <div class="col-sm-4 col-xs-6"><input class="form-control" name="txtfax" type="text" id="txtfax" value="<?php echo $fax;?>"/></div>
                                </div>
                                <div class="form-group">
                                    <label for="txtemail" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-9"><input class="form-control" name="txtemail" type="text" id="txtemail" value="<?php echo $email;?>"/></div>                                    
                                </div>
                            </div>
                            <!-- /.box-body -->  
                        </div>
                        <div class="col-md-6">
                            <div class="box-body">                                
                                <div class="form-group">
                                    <label for="txtfile" class="col-sm-3 control-label">Logo</label>
                                    <div class="col-sm-offset-3 col-sm-9 text-center">
                                        <div class="preview" style="height:203px;width:203px;"><span>128 x 128px</span></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <input class="form-control no-padding" type="file" name="txtfile" id="txtfile"/>
                                        <span id="txtfilename">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button name="btnsimpan" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg"><i class="fa fa-save"></i><span class="hidden-xs"> Simpan</span></button>
                        <button name="btnbatal" type="reset" class="btn btn-default hidden-xs"><i class="fa fa-remove"></i> Tutup</button>
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