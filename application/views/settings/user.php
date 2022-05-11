<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
    $(document).ready(function()
    {
		$.classTable();
        
        $("button[name=btnbaru]").click(function(e) 
        {
            $.ajax({
                type: "post",
                dataType: "html",
                url: "<?php echo base_url();?>settings/adduser",
                beforeSend: function() {
                    $(".content-wrapper").html('');
                },
                success: function(content) {
                    $(".content-wrapper").html(content);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.statusText);
                    alert(xhr.responseText);
                }
            });
            e.preventDefault();
        });
		
        <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'new') == 'N'):?>
            $("button[name=btnbaru]").attr("disabled", true);
        <?php else:?>
            $("button[name=btnbaru]").focus();
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

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-header with-border">
                    <h3 class="box-title hidden-xs"><i class="fa fa-user"></i> <?php echo 'DATA '.$caption;?></h3>
                    <button name="btnbaru" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg hidden-lg hidden-md hidden-sm"><i class="fa fa-plus"></i></button>
                    <div class="box-tools">
                        <form id="navbar-form" method="post" action="<?php echo base_url()."settings/datauser";?>">
                        <div class="input-group input-group-sm visible-input-group-lg" style="width: 200px;">                            
                            <input type="text" id="txtsearch" name="txtsearch" class="form-control pull-right" placeholder="Search" value="<?php echo ($search != "null" ? $search : null);?>">
                            <div class="input-group-btn">
                                <button name="btncari" type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
            
                <div class="box-body">
                    <table id="tabledata" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width="4%">No</th>
                                <th class="text-center hidden-lg hidden-md hidden-sm">Keterangan</th>
                                <th class="hidden-xs" width="12%">IDPengguna</th>
                                <th class="hidden-xs">Pengguna</th>
                                <th class="hidden-xs"width="6%">Level</th>
                                <th class="hidden-xs"width="6%">Status</th>
                                <th class="hidden-xs"width="6%">Reset</th>
                                <th class="hidden-xs"width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" name="search" value="<?php echo $search;?>">
                            <input type="hidden" name="page" value="<?php echo $page;?>">
                            <?php if(isset($datas) and $datas != false): $i = 1;?>
                                <?php foreach ($datas as $row):?>
                                    <tr data-href="<?php echo base_url()."settings/edituser/".$search."/".$page."/".$row->id;?>">
                                        <td class="text-center"><?php echo $page+$i;?></td>
                                        <td class="hidden-lg hidden-md hidden-sm hidden-xs">
                                            <div class="col-xs-2 no-padding text-center"><img src="<?php echo base_url().'arsip/photo/'.$row->foto;?>" width="40" height="40"></div>
                                            <div class="col-xs-5"><strong><?php echo $row->userid;?></strong></div>
                                            <div class="col-xs-5 text-right no-padding"><em><?php echo ($row->tanggal != "-" ? $row->tanggal : "&nbsp;");?></em></div>
                                            <div class="col-xs-10"><?php echo $row->nama;?></div>
                                        </td>
                                        <td class="text-center hidden-xs"><?php echo $row->userid;?></td>
                                        <td class="hidden-xs"><?php echo $row->nama;?></td>
                                        <td class="text-center hidden-xs"><?php echo $row->level;?></td>
                                        <td class="text-center hidden-xs">
                                            <div class="btn-group">
                                                <?php if ($row->aktif == 'Y'):?>
                                                    <?php if ($row->userid != 'admin' && getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y'):?>
                                                        <a class="btn btn-success btn-sm" href="<?php echo base_url()."settings/activeuser/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-check"></i></a>
                                                    <?php else:?>
                                                        <a class="btn btn-success btn-sm disabled" href="#" title="Aktif Data"><i class="fa fa-check"></i></a>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <?php if ($row->userid != 'admin' && getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y'):?>
                                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url()."settings/activeuser/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-close"></i></a>
                                                    <?php else:?>
                                                        <a class="btn btn-danger btn-sm disabled" href="#"><i class="fa fa-close"></i></a>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td class="text-center hidden-xs">
                                            <div class="btn-group">
                                                <?php if ($row->userid != 'admin' && getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y'):?>
                                                    <a class="btn btn-warning btn-sm" href="<?php echo base_url()."settings/resetuser/".$search."/".$page."/".$row->id; ?>" title="Reset Data"><i class="fa fa-refresh"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-warning btn-sm disabled" href="#" title="Reset Data"><i class="fa fa-refresh"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td class="text-center hidden-xs">
                                            <div class="btn-group">
                                                <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'delete') == 'Y'):?>
                                                    <a class="btn btn-info btn-sm" href="<?php echo base_url()."settings/edituser/".$search."/".$page."/".$row->id;?>" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-info btn-sm disabled" href="#" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php endif;?>
                                                <?php if ($row->userid != 'admin' && getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'delete') == 'Y'):?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url()."settings/deluser/".$search."/".$page."/".$row->id;?>" title="Hapus Data" col="1"><i class="fa fa-trash-o"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-danger btn-sm disabled" href="#" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                <?php endforeach;?>	
                                <?php for ($j = $i; $j <= $this->config->item('show_data'); $j++):?>
                                    <tr data-href="">
                                        <td class="text-center"><?php echo $page+$j;?></td>
                                        <td>&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                    </tr>
                                <?php endfor;?>
                            <?php else:?>
                                <?php for ($j = 1; $j <= $this->config->item('show_data'); $j++):?>
                                    <tr data-href="">
                                        <td class="text-center"><?php echo $j;?></td>
                                        <td>&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                    </tr>
                                <?php endfor;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="col-sm-6 no-padding hidden-xs">
                        <button name="btnbaru" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?>"><i class="fa fa-plus"></i> Baru</button>
                    </div>
                    <div id="pagination" class="col-sm-6 col-xs-12 no-padding">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col-xs-12 -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->