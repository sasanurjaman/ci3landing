<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
    $(document).ready(function()
    {
    	$("button[name=btnbaru]").click(function(e) 
        {
            $.ajax({
                type: "post",
                dataType: "html",
                url: "<?php echo base_url();?>transactions/addagenda",
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
		
        <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'new') == 'N'):?>
            $("input:submit[name=btnbaru]").attr("disabled", true).addClass("disabled");
        <?php else:?>
            $('input:submit[name=btnbaru]').focus();
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

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-sticky-note-o"></i> <?php echo 'DATA '.$caption;?></h3>
                    <div class="box-tools">
                        <form class="search-bar" method="post" action="<?php echo base_url()."transactions/datagenda";?>">
                        <div class="input-group input-group-sm" style="width: 200px;">                            
                            <input type="text" name="txtsearch" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button name="btncari" type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
            
                <div class="box-body">                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="4%">No</th>
                                <th width="10%">Tanggal</th>
                                <th width="7%">Waktu</th>
                                <th>Kegiatan</th>
                                <th width="20%">Keterangan</th>
                                <th width="6%">Status</th>
                                <th width="9%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" name="search" value="<?php echo $search;?>">
                            <input type="hidden" name="page" value="<?php echo $page;?>">
                            <?php if(isset($datas) and $datas != false): $i = 1;?>
                                <?php foreach ($datas as $row):?>
                                    <tr>
                                        <td class="center"><?php echo $page+$i;?></td>
                                        <td class="center"><?php echo ($row->tanggal != '-' ? $row->tanggal : null);?></td>
                                        <td class="center"><?php echo ($row->waktu != '-' ? $row->waktu : null);?></td>
                                        <td><?php echo ($row->kegiatan != '-' ? $row->kegiatan : null)?></td>
                                        <td><?php echo ($row->keterangan != '-' ? $row->keterangan : null)?></td>
                                        <td class="center">
                                            <div class="btn-group">
                                                <?php if ($row->status == "Y"):?>
                                                    <a class="btn btn-success btn-sm" href="<?php echo base_url()."transactions/activeagenda/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-check"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url()."transactions/activeagenda/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-close"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td class="center">
                                            <div class="btn-group">
                                                <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'edit') == 'Y'):?>
                                                    <a class="btn btn-info btn-sm" href="<?php echo base_url()."transactions/editagenda/".$search."/".$page."/".$row->id;?>" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-info btn-sm disabled" href="#" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php endif;?>
                                                <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'delete') == 'Y'):?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url()."transactions/delagenda/".$search."/".$page."/".$row->id;?>" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
                                                <?php else:?>    
                                                    <a class="btn btn-danger btn-sm disabled" href="#" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                    <?php endforeach;?>
                                    <?php for ($j = $i; $j <= $this->config->item('show_data'); $j++):?>
                                        <tr>
                                            <td class="center"><?php echo $page+$j;?></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    <?php endfor;?>	
                            <?php else:?>
                                <?php for ($j = 1; $j <= $this->config->item('show_data'); $j++):?>
                                    <tr>
                                        <td class="center"><?php echo $j;?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php endfor;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                
                <div class="box-footer clearfix">
                    <div class="col-xs-6">
                        <button name="btnbaru" type="submit" class="btn btn-primary">Baru</button>
                    </div>
                    <div id="pagination" class="col-xs-6">
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