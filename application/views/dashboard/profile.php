<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (isset($datas) && $datas != false)  
{
	$name = $this->session->userdata('SESS_USER_NAME');
    $alias = ($datas->alias != '-' ? $datas->alias : set_value('txtalias'));
	$sex = ($datas->kelamin != '-' ? $datas->kelamin : set_value('txtsex'));
	$marital = ($datas->status != '-' ? $datas->status : set_value('txtmarital'));
	$pob = ($datas->tmplahir != '-' ? $datas->tmplahir : set_value('txtpob'));
	$dob = ($datas->tglahir != '00-00-0000' ? $datas->tglahir : set_value('txtdob'));
    $cell = ($datas->selular != '-' ? $datas->selular : set_value('txtcell'));
    $place = ($datas->tmptinggal != '-' ? $datas->tmptinggal : set_value('txtplace'));
    $email = ($datas->email != '-' ? $datas->email : set_value('txtemail'));
    $web = ($datas->website != '-' ? $datas->website : set_value('txtweb'));
    $facebook = ($datas->facebook != '-' ? $datas->facebook : set_value('txtfacebook'));
    $twitter = ($datas->twitter != '-' ? $datas->twitter : set_value('txtwitter'));	
	$note = ($datas->keterangan != '-' ? $datas->keterangan : set_value('txtnote'));
	$foto = ($datas->foto != '-' ? base_url().'arsip/photo/'.$datas->foto : base_url().'arsip/photo/nopicture.png');
}?>
<script type="text/javascript">
	$(document).ready(function() 
    {
        $("#txtdob").datepicker({
            autoclose: true,
            format:"dd-mm-yyyy"
        });
        
        $("input:file").on("change", function(e) 
        {
            $("#txtlogin, #txtname, #txtlevel").each(function() {
                $(this).prop("disabled", false).css({"background-color": "#eeeeee", "color": "#6d6d6d", "font-style": "italic"});
            });
            var formData = new FormData($("form")[1]); 
            
            $.ajax({
                type: "post",
                dataType: 'json',
                url: "<?php echo base_url();?>settings/uploadtmp",
                data: formData,
                success: function(d) 
                {
                    /*console.log( JSON.stringify(d) );*/
                    $("#txtlogin, #txtname, #txtlevel").each(function() {
                        $(this).prop("disabled", true);
                    });
                    if (d.notif == "modal-success")
                    {
                        $(".preview").html("<img src='<?php echo base_url();?>tmp/"+d.filename+"' width='122' height='122'>");
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
                    alert(xhr.statusText);
                    alert(xhr.responseText);
                }
            });
            e.preventDefault();
        });
        
        $(".nav li a").each(function()
        {
            $(this).click(function()
            {  
                if ($(this).attr("href") == "#tab-2")
                    interval = setInterval(timeLine, 10000);
                else
                    clearInterval(interval);
            });
        });
        
        $("button[name=btnsimpan]").on("click", function(e) 
        {
            $("#txtlogin, #txtname, #txtlevel").each(function() {
                $(this).prop("disabled", false).css({"background-color": "#eeeeee", "color": "#6d6d6d", "font-style": "italic"});
            });
            var formData = new FormData($("form")[1]); 
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo base_url();?>dashboard/updateprofile",
                data: formData,
                success: function(d) 
                {
                    /*console.log( JSON.stringify(d) );*/
                    $("#txtlogin, #txtname, #txtlevel").each(function() {
                        $(this).attr("disabled", true);
                    });
                    
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
        
        $(".preview").html("<img src='<?php echo $foto;?>' width='122' height='122'>");
        <?php if (basename($foto) == "nopicture.png"):?>
            $("#txtfilename").html("");
        <?php else:?>
            $("#txtfilename").html("<?php echo basename($foto);?>");
        <?php endif;?>
    });            
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo ($caption != "" ? $caption."<small>Control panel</small>" : "Dashboard<small>Control panel</small>");?></h1>
    <ol class="breadcrumb hidden-xs">
        <li><a href="#"><i class="<?php echo $logo;?>"></i> <?php echo $mainpage;?></a></li>
        <?php if ($caption != ""):?>
            <li class="active"><?php echo $caption?></li>
        <?php endif?>
    </ol>
</section>
                
<section class="content">
    <div class="row">        
        <section class="col-sm-3">
            <!-- Profile Image -->
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()."arsip/photo/".($this->session->userdata('SESS_USER_PHOTO') != "-" ? $this->session->userdata('SESS_USER_PHOTO') : "nopicture.png");?>" alt="User profile picture">
                    <h3 class="profile-username text-center"><?php echo $this->session->userdata('SESS_USER_NAME');?></h3>
                    <p class="text-muted text-center">
                        <?php if ($this->session->userdata('SESS_USER_ID') == 'admin'):
                            echo '<em>web administrator</em>';
                        else:
                            echo '';
                        endif;?>
                    </p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bookmark margin-r-5"></i>Tentang Saya</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-user margin-r-5"></i> Nama Login</strong>
                    <p class="text-muted" style="margin-left:20px;"><?php echo $this->session->userdata('SESS_USER_ID');?></p>
                    <strong><i class="fa fa-user margin-r-5"></i> Nama</strong>
                    <p class="text-muted" style="margin-left:20px;"><?php echo $this->session->userdata('SESS_USER_NAME');?></p>
                    <strong><i class="fa fa-calendar margin-r-5"></i> Tanggal Daftar</strong>
                    <p class="text-muted" style="margin-left:20px;"><?php echo ($datas != false ? $datas->daftar : null);?></p>
                    <strong><i class="fa fa-clock-o margin-r-5"></i> Login Terakhir</strong>
                    <p class="text-muted" style="margin-left:20px;"><?php echo ($datas != false ? $datas->login : null);?></p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.col -->
        
        <section class="col-sm-9">
                    <div class="nav-tabs-custom tab-<?php echo $this->config->item('site_theme');?>">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-user margin-r-5"></i>Profile</a></li>
                            <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-refresh margin-r-5"></i>Aktifitas</a></li>
                            <li><a href="#tab-3" data-toggle="tab"><i class="fa fa-edit margin-r-5"></i>Update Profile</a></li>
                        </ul>
                            
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab-1">
                                <div class="box no-border no-shadow no-margin">
                                    <div class="box-header">
                                        <div style="font-size:16pt;font-weight:normal;">Hai..., Nama Saya <?php echo ucfirst($this->session->userdata('SESS_USER_NAME'));?></div>
                                        <div style="font-size:11pt;">
                                            <?php if ($this->session->userdata('SESS_USER_ID') == 'admin'):
                                                echo '<em>web administrator</em>';
                                            else:
                                                echo '<em>'.'</em>';
                                            endif;?>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    
                                    <div class="box-body">
                                        <p class="no-margin" style="text-align:justify;">
                                            <?php echo (isset($note)&&$note!='' ? $note : ucfirst($this->session->userdata('SESS_USER_NAME')).' lahir di '.(isset($pob)?ucfirst($pob):null).' pada tanggal '.(isset($dob)?$dob:null).' adalah karyawan '.getCompany()->nama.'.');?>
                                        </p>
                                    </div>
                                    <!-- .box-body -->
                                </div>
                                <!-- .box -->
                                <div class="box no-border no-shadow no-margin">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-user margin-r-5"></i>Personal Info</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    
                                    <div class="box-body">
                                        <div class="form-horizontal">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Nama</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$this->session->userdata('SESS_USER_NAME');?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Kelamin</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$sex;?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Tmp/Tgl Lahir</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$pob.($dob != '' ? ', '.date('d F Y', strtotime($dob)) : null);?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Status</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$marital;?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Tmp Tinggal</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$place;?></span></div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Seluler</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$cell;?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Email</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$email;?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Facebook</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$facebook;?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Twitter</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$twitter;?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-4 col-sm-4 control-label no-margin">Website</label>
                                                        <div class="col-xs-8 col-sm-8 no-margin"><span class="form-control no-border"><?php echo ': '.$web;?></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .box-body -->
                                </div>
                                <!-- .box -->
                                <div class="box no-border no-shadow no-margin">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-building margin-r-5"></i>Company Info</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    
                                    <div class="box-body">
                                        <div class="form-horizontal">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-8">
                                                    <div class="form-group">
                                                        <label class="col-xs-3 col-sm-3 control-label no-margin">Perusahaan</label>
                                                        <div class="col-xs-9 col-sm-9 no-margin"><span class="form-control no-border"><?php echo ': '.getCompany()->nama;?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-3 col-sm-3 control-label no-margin">Bagian</label>
                                                        <div class="col-xs-9 col-sm-9 no-margin"><span class="form-control no-border"><?php echo ': ';?></span></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-3 col-sm-3 control-label no-margin">Jabatan</label>
                                                        <div class="col-xs-9 col-sm-9 no-margin"><span class="form-control no-border"><?php echo ': ';?></span></div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 form-group">
                                                    <div class="logo"><img src="<?php echo base_url().'images/'.getCompany()->logo;?>" height="128"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .box-body -->
                                </div>
                                <!-- .box -->
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <?php if (isset($dataction) && $dataction != false): $i = 1;?>
                                    <!-- The timeline -->
                                    <ul class="timeline timeline-inverse">
                                        <?php $actdate = '';?>
                                        <?php foreach($dataction AS $row):?>
                                            <?php $bgcolors = array('bg-red', 'bg-green', 'bg-blue', 'bg-yellow', 'bg-aqua', 'bg-purple'); $n = array_rand($bgcolors, 1);?>
                                            <!-- timeline time label -->
                                            <?php if ($actdate != $row->tanggal):?>
                                                <?php $bgcolor = (date('D', strtotime($row->tanggal)) === 'Sun' ? 'bg-red' : 'bg-gray');?>
                                                <li class="time-label">
                                                    <span class="<?php echo $bgcolor;?>"><?php $actdate = $row->tanggal; echo $actdate;?></span>
                                                </li>
                                            <?php endif;?>
                                            <li>
                                                <i class="fa <?php echo $row->simbol;?> <?php echo getColors($row->simbol);?>"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o margin-r-5"></i><?php echo $row->jam;?></span>
                                                    <h3 class="timeline-header">
                                                        <img style="width:20px;height:20px;border-radius:50%;margin-right:5px;" src="<?php echo base_url().'arsip/photo/'.(getData('foto', 'user', 'userid = "'.$row->pengguna.'"') != '-' ? getData('foto', 'user', 'userid = "'.$row->pengguna.'"') : 'nopicture.png');?>" alt="Foto">
                                                        <?php echo getData('nama', 'user', 'userid = "'.$row->pengguna.'"');?>
                                                    </h3>
                                                    <div class="timeline-body"><?php echo $row->keterangan;?></div>
                                                </div>
                                            </li>
                                        <?php endforeach;?>
                                        <li><i class="fa fa-clock-o bg-gray"></i></li>
                                    </ul>
                                    <!-- /.timeline -->
                                <?php endif;?>
                            </div>
                            <div class="tab-pane" id="tab-3">
                                <form class="form-horizontal" role="form" method="post" action="#">
                                    <?php echo form_hidden('txtmp');?>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="txtlogin" class="col-sm-3 control-label">Nama Login</label>
                                                <div class="col-sm-9"><input type="text" class="form-control" id="txtlogin" name="txtlogin" placeholder="Nama Login Pengguna" value="<?php echo $this->session->userdata('SESS_USER_ID');?>" disabled></div>                                                
                                            </div>
                                            <div class="form-group">
                                                <label for="txtname" class="col-xs-12 col-sm-3 control-label">Nama</label>
                                                <div class="col-xs-8 col-sm-6"><input type="text" class="form-control" id="txtname" name="txtname" placeholder="Nama Lengkap" value="<?php echo $this->session->userdata('SESS_USER_NAME');?>" disabled></div>
                                                <div class="col-xs-4 col-sm-3"><input type="text" class="form-control text-center uppercase" id="txtalias" name="txtalias" placeholder="Nama Alias" value="<?php echo (isset($alias)?$alias:null);?>"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtnote" class="col-sm-3 control-label">Biografi</label>
                                                <div class="col-sm-9"><textarea type="text" class="form-control" id="txtnote" name="txtnote" placeholder="Biografi Pengguna"><?php echo (isset($note)?$note:null);?></textarea></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <div class="preview"><span>128 x 128px</span></div>
                                            <input style="width:80px;margin:0 auto;margin-top:5px;color:transparent" id="txtfile" name="txtfile" type="file" class="form-control no-padding"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="txtpob" class="col-sm-4 control-label">Tmp Lahir</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtpob" name="txtpob" placeholder="Tempat Lahir" value="<?php echo (isset($pob)?$pob:null);?>"></div>                                                
                                            </div>
                                            <div class="form-group">
                                                <label for="txtsex" class="col-sm-4 control-label">Kelamin</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtsex" name="txtsex" placeholder="Jenis Kelamin" value="<?php echo (isset($sex)?$sex:null);?>"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtplace" class="col-sm-4 control-label">Tmp Tinggal</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtplace" name="txtplace" placeholder="Tempat Tinggal" value="<?php echo (isset($place)?$place:null);?>"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtemail" class="col-sm-4 control-label">Email</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtemail" name="txtemail" placeholder="Alamat Email" value="<?php echo (isset($email)?$email:null);?>"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtfacebook" class="col-sm-4 control-label">Facebook</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtfacebook" name="txtfacebook" placeholder="Alamat Facebook" value="<?php echo (isset($facebook)?$facebook:null);?>"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="txtlevel" class="col-sm-4 control-label">Tgl Lahir</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" class="form-control text-center" id="txtdob" name="txtdob" value="<?php echo (isset($dob)?$dob:date('d-m-Y'));?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtmarital" class="col-sm-4 control-label">Status</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtmarital" name="txtmarital" placeholder="Status Perkawinan" value="<?php echo (isset($marital)?$marital:null);?>"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtcell" class="col-sm-4 control-label">Selular</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtcell" name="txtcell" placeholder="Nomor Selular" value="<?php echo (isset($cell)?$cell:null);?>"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtweb" class="col-sm-4 control-label">Website</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtweb" name="txtweb" placeholder="Alamat Website" value="<?php echo (isset($web)?$web:null);?>"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtwitter" class="col-sm-4 control-label">Twitter</label>
                                                <div class="col-sm-8"><input type="text" class="form-control" id="txtwitter" name="txtwitter" placeholder="Alamat Twitter" value="<?php echo (isset($twitter)?$twitter:null);?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button id="btnsimpan" name="btnsimpan" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg"><i class="fa fa-save"></i><span class="hidden-xs margin-l-5">Simpan</span></button>
                                        </div>
                                    </div>
                                </form>    
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
        </section>
        <!-- /.col -->
    </div>
</section>