<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$mainmenu = $this->config->item('menu_sidebar');?>
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/all.css">
<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">
    $(function() {
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
    
    $(document).ready(function()
    {
        $.classTable();
        
        $(".select2").select2(
        {
            placeholder: "Pilih Nama Pengguna",
            minimumInputLength: 0,
            ajax: {
                url: "<?php echo base_url();?>settings/combouser",
                type: "post",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        txtkey: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    /*console.log(JSON.stringify(data));*/
                    params.page = params.page || 1;
                    return {
                      results: data.items,
                      pagination: {
                        more: (params.page * 10) < data.total_count
                      }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
              return markup;
            },
            templateResult: function(repo) {
              if (repo.loading) return repo.text;
              return repo.text;
            },
            templateSelection: function(repo) {
              return repo.text;
            }
        });
        
        $("#txtuserid").on("change", function() 
        {
			var userid = $(this).val();
            $.ajax(
            {
                type: "post",
                dataType: "json",
                url: "<?php echo base_url();?>settings/getpermission",
                data: "txtuserid=" + userid,
                success: function(data) 
                {
                    console.log(JSON.stringify(data));
                    if (data == false) 
                    {
                        $("input:checkbox").iCheck("uncheck");
                    } 
                    else 
                    {
						$.each(data, function(i,item)
                        {
							<?php if (count($mainmenu) > 0):?>
                                <?php $n = 0; foreach ($mainmenu AS $header):?>
                                    var header_access = data.<?php echo $header['column']?>.split("|");
                                    if (header_access[0]=="D")
                                        $("<?php echo '#'.$header['title'].'0';?>").iCheck("check").iCheck("disable");
                                    else if (header_access[0]=="Y")
                                        $("<?php echo '#'.$header['title'].'0';?>").iCheck("check");
                                    else
                                        $("<?php echo '#'.$header['title'].'0';?>").iCheck("uncheck");
                                        
                                        <?php foreach ($header['submenu'] AS $submenu):?>
                                            <?php if ($submenu['submenus'] == 0):?>
                                                var access = data.<?php echo $submenu['subcol']?>.split("|");                                            
                                                for (var a=0; a<access.length; a++) 
                                                {
                                                    if (access[a]=="D")
                                                        $("<?php echo '#'.$submenu['subtitle'];?>"+a).iCheck("check").iCheck("disable");
                                                    else if (access[a]=="Y")
                                                        $("<?php echo '#'.$submenu['subtitle'];?>"+a).iCheck("check");
                                                    else
                                                        $("<?php echo '#'.$submenu['subtitle'];?>"+a).iCheck("uncheck");
                                                }
                                            <?php else:?>
                                                <?php foreach ($submenu['submenus'] AS $subsubmenu):?>
                                                    var access = data.<?php echo $subsubmenu['subcols']?>.split("|");                                            
                                                    for (var a=0; a<access.length; a++) 
                                                    {
                                                        if (access[a]=="D")
                                                            $("<?php echo '#'.$subsubmenu['subtitles'];?>"+a).iCheck("check").iCheck("disable");
                                                        else if (access[a]=="Y")
                                                            $("<?php echo '#'.$subsubmenu['subtitles'];?>"+a).iCheck("check");
                                                        else
                                                            $("<?php echo '#'.$subsubmenu['subtitles'];?>"+a).iCheck("uncheck");
                                                    }
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                <?php $n++; endforeach;?>
                            <?php endif;?>
						});
					}
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.statusText);
                    alert(xhr.responseText);
                }
            });
		});
		
        $("button[name=btnsimpan]").on("click", function(e) 
        {
            var formData = new FormData($("form")[1]); 
            
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '<?php echo base_url();?>settings/updatepermission',
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
        
        $('button[name=btnbatal]').on('click', function() {
            $('.content-wrapper').html('');
        });
        
		<?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S4', 'edit') == 'N'):?>
			$("#txtuserid").attr("disabled", true).css({"background-color": "#EEEEEE", "color": "#6D6D6D", "font-style": "italic"});
            $("input[type='checkbox'].minimal").iCheck("disable");		
			$("button[name=btnsimpan]").attr("disabled", true);
            $("button[name=btnbatal]").focus();
        <?php else:?>
            $("#txtuserid").focus();
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
        <div class="col-sm-12">
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-check-square-o"></i> <?php echo $caption?></h3>
                    <div class="box-tools pull-right">
                        <button name="btnbatal" type="reset" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                
                <form class="form-horizontal" role="form" method="post" action="#" enctype="multipart/form-data">
                <div class="box-header with-border">
                    <div class="form-group">
                        <label for="txtuserid" class="col-sm-2 control-label">ID Pengguna</label>
                        <div class="col-sm-3"><select class="form-control select2" style="width: 100%;" name="txtuserid" id="txtuserid">
                            <option value="" selected="selected">Search ...</option>
                        </select></div>
                    </div>
                </div>
                <!-- /.box-header -->
            
                <div class="box-body">
                    <div class="nav-tabs-custom tab-<?php echo $this->config->item('site_theme');?>">
                        <ul class="nav nav-tabs">
                            <?php if (count($mainmenu) > 0):?>
                                <?php $n = 0; foreach ($mainmenu AS $header):?>
                                    <?php if ($n > -1):?>
                                        <?php $vals = explode('|', $header['value']);?>
                                        <li class="<?php echo ($n == 0 ? 'active' : null);?>"><a href="#tabs-<?php echo $n;?>" data-toggle="tab"><input id="<?php echo $header['title'].'0';?>" name="<?php echo $header['title'].'0';?>" type="checkbox" class="minimal" value="<?php echo $vals[0];?>"/><i class="<?php echo $header['logo']?> margin-l-5 margin-r-5"></i><?php echo $header['name'];?></a></li>                                    
                                    <?php endif;?>
                                <?php $n++; endforeach;?>
                            <?php else:?>
                                <li class="active"><a href="#tabs-1" data-toggle="tab"><i class="fa fa-gears margin-r-5"></i>Pengaturan</a></li>
                            <?php endif;?>
                        </ul>
                        <div class="tab-content">
                            <?php if (count($mainmenu) > 0):?>
                                <?php $n = 0; foreach ($mainmenu AS $header):?>
                                    <?php if ($n > -1):?>
                                        <div class="<?php echo ($n == 0 ? 'active' : null);?> tab-pane" id="tabs-<?php echo $n;?>">
                                            <table class="table table-bordered no-margin">
                                                <thead>
                                                    <tr>
                                                        <th>Menu</th>
                                                        <th width="6%">Baca</th>
                                                        <th width="6%">Baru</th>
                                                        <th width="6%">Ubah</th>
                                                        <th width="6%">Hapus</th>
                                                        <th width="6%">Cetak</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($header['submenu'] AS $submenu):?>
                                                        <?php $vals = explode('|', $submenu['subvalue']);?>
                                                        <?php if ($submenu['submenus'] == '0'):?>
                                                            <tr>
                                                                <td><i class="<?php echo $submenu['sublogo']?> margin-r-5"></i><?php echo $submenu['subname'];?></td>
                                                                <td class="center"><input id="<?php echo $submenu['subtitle'].'0';?>" name="<?php echo $submenu['subtitle'].'0';?>" type="checkbox" class="minimal" value="<?php echo $vals[0];?>"/></td>
                                                                <td class="center"><input id="<?php echo $submenu['subtitle'].'1';?>" name="<?php echo $submenu['subtitle'].'1';?>" type="checkbox" class="minimal" value="<?php echo $vals[1];?>"/></td>
                                                                <td class="center"><input id="<?php echo $submenu['subtitle'].'2';?>" name="<?php echo $submenu['subtitle'].'2';?>" type="checkbox" class="minimal" value="<?php echo $vals[2];?>"/></td>
                                                                <td class="center"><input id="<?php echo $submenu['subtitle'].'3';?>" name="<?php echo $submenu['subtitle'].'3';?>" type="checkbox" class="minimal" value="<?php echo $vals[3];?>"/></td>
                                                                <td class="center"><input id="<?php echo $submenu['subtitle'].'4';?>" name="<?php echo $submenu['subtitle'].'4';?>" type="checkbox" class="minimal" value="<?php echo $vals[4];?>"/></td>
                                                            </tr>
                                                        <?php else:?>
                                                            <tr>
                                                                <td><i class="<?php echo $submenu['sublogo']?> margin-r-5"></i><?php echo $submenu['subname'];?></td>
                                                                <td class="center">&nbsp;</td>
                                                                <td class="center">&nbsp;</td>
                                                                <td class="center">&nbsp;</td>
                                                                <td class="center">&nbsp;</td>
                                                                <td class="center">&nbsp;</td>
                                                            </tr>
                                                            <?php foreach ($submenu['submenus'] AS $subsubmenu):?>
                                                                <?php $vals = explode('|', $subsubmenu['subvalues']);?>
                                                                <tr>
                                                                    <td style="padding-left:30px;"><i class="<?php echo $subsubmenu['sublogos']?> margin-r-5"></i><?php echo $subsubmenu['subnames'];?></td>
                                                                    <td class="center"><input id="<?php echo $subsubmenu['subtitles'].'0';?>" name="<?php echo $subsubmenu['subtitles'].'0';?>" type="checkbox" class="minimal" value="<?php echo $vals[0];?>"/></td>
                                                                    <td class="center"><input id="<?php echo $subsubmenu['subtitles'].'1';?>" name="<?php echo $subsubmenu['subtitles'].'1';?>" type="checkbox" class="minimal" value="<?php echo $vals[1];?>"/></td>
                                                                    <td class="center"><input id="<?php echo $subsubmenu['subtitles'].'2';?>" name="<?php echo $subsubmenu['subtitles'].'2';?>" type="checkbox" class="minimal" value="<?php echo $vals[2];?>"/></td>
                                                                    <td class="center"><input id="<?php echo $subsubmenu['subtitles'].'3';?>" name="<?php echo $subsubmenu['subtitles'].'3';?>" type="checkbox" class="minimal" value="<?php echo $vals[3];?>"/></td>
                                                                    <td class="center"><input id="<?php echo $subsubmenu['subtitles'].'4';?>" name="<?php echo $subsubmenu['subtitles'].'4';?>" type="checkbox" class="minimal" value="<?php echo $vals[4];?>"/></td>
                                                                </tr>
                                                            <?php endforeach;?>
                                                        <?php endif;?>
                                                    <?php endforeach;?>                                        
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.#tabs -->
                                    <?php endif;?>
                                <?php $n++; endforeach;?>
                            <?php else:?>
                                <div class="tab-pane" id="tabs-1">
                                    <table class="table table-bordered no-margin">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th width="6%">Baca</th>
                                                <th width="6%">Baru</th>
                                                <th width="6%">Ubah</th>
                                                <th width="6%">Hapus</th>
                                                <th width="6%">Cetak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Instansi</td>
                                                <td class="center"><input id="txtinstansi0" name="txtinstansi0" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtinstansi1" name="txtinstansi1" type="checkbox" class="minimal" value="D"/></td>
                                                <td class="center"><input id="txtinstansi2" name="txtinstansi2" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtinstansi3" name="txtinstansi3" type="checkbox" class="minimal" value="D"/></td>
                                                <td class="center"><input id="txtinstansi4" name="txtinstansi4" type="checkbox" class="minimal" value="D"/></td>
                                            </tr>
                                            <tr>
                                                <td>Pengguna</td>
                                                <td class="center"><input id="txtpengguna0" name="txtpengguna0" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtpengguna1" name="txtpengguna1" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtpengguna2" name="txtpengguna2" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtpengguna3" name="txtpengguna3" type="checkbox" class="minimal" value="N"/></td>
                                                <td class="center"><input id="txtpengguna4" name="txtpengguna4" type="checkbox" class="minimal" value="N"/></td>
                                            </tr>
                                            <tr>
                                                <td>Katasandi</td>
                                                <td class="center"><input id="txtkatasandi0" name="txtkatasandi0" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtkatasandi1" name="txtkatasandi1" type="checkbox" class="minimal" value="D"/></td>
                                                <td class="center"><input id="txtkatasandi2" name="txtkatasandi2" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtkatasandi3" name="txtkatasandi3" type="checkbox" class="minimal" value="D"/></td>
                                                <td class="center"><input id="txtkatasandi4" name="txtkatasandi4" type="checkbox" class="minimal" value="D"/></td>
                                            </tr>
                                            <tr>
                                                <td>Aplikasi</td>
                                                <td class="center"><input id="txtaplikasi0" name="txtaplikasi0" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtaplikasi1" name="txtaplikasi1" type="checkbox" class="minimal" value="D"/></td>
                                                <td class="center"><input id="txtaplikasi2" name="txtaplikasi2" type="checkbox" class="minimal" value="Y"/></td>
                                                <td class="center"><input id="txtaplikasi3" name="txtaplikasi3" type="checkbox" class="minimal" value="D"/></td>
                                                <td class="center"><input id="txtaplikasi4" name="txtaplikasi4" type="checkbox" class="minimal" value="D"/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.#tabs-2 -->
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- /.nav-tabs-custom -->
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