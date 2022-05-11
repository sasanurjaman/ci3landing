<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
    $(document).ready(function()
    {
    	$("button[name=btncetak]").click(function(e) 
        {
            var xMax = screen.availWidth;
			var yMax = screen.availHeight;
			var xOffset = (xMax - 800)/2, yOffset = (yMax - yMax)/2;
			
			var url = "<?php echo base_url();?>index.php/reports/printagenda";
            var windowName = "popUp";//$(this).attr("name");
            var windowSize = 'scrollbars=yes,menubar=yes,width=800,height='+yMax+',screenX='+xOffset+',screenY='+yOffset+',top='+yOffset+',left='+xOffset;
 
            window.open(url, windowName, windowSize);
            e.preventDefault();
        });
		
        $("button[name=btnbatal]").on("click", function() 
        {
            $.ajax({
                type: "post",
                dataType: "html",
                url: "<?php echo base_url();?>index.php/reports/agenda",
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
        
        <?php if ($this->sim_model->access($this->session->userdata('SESS_USER_ID'), 'L3', 'print') == 'N'):?>
            $("button[name=btncetak]").attr("disabled", true);
        <?php else:?>
            $("button[name=btncetak]").focus();
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
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo "DATA ".$caption;?></h3>
                </div>
                <!-- /.box-header -->
            
                <div class="box-body">
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Tanggal</th>
                                <th width="8%">Waktu</th>
                                <th>Acara</th>
                                <th width="8%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" name="page" value="<?php echo $page;?>">
                            <?php if(isset($datas) and $datas != false): $i = 1;?>
                                <?php foreach ($datas as $row):?>
                                    <tr>
                                        <td class="center"><?php echo $page+$i;?></td>
                                        <td class="center"><?php echo $row->tanggal;?></td>
                                        <td class="center"><?php echo $row->waktu;?></td>
                                        <td><?php echo $row->kegiatan;?></td>
                                        <td class="center">
                                            <div class="btn-group">
                                                <?php if ($row->status == 'Y'):?>
                                                    <a class="btn btn-success btn-sm disabled" href="#" title="Aktif Data"><i class="fa fa-check"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-danger btn-sm disabled" href="#" title="Aktif Data"><i class="fa fa-close"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach;?>	
                                <?php for ($j = $i; $j <= $this->config->item('show_data'); $j++):?>
                                    <tr>
                                        <td class="center"><?php echo $page+$j;?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php endfor;?>					
                            <?php else:?>
                                <?php for ($j = 1; $j <= $this->config->item('show_data'); $j++):?>
                                    <tr>
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
                        <button name="btncetak" type="submit" class="btn btn-primary">Cetak</button>
                        <button name="btnbatal" type="reset" class="btn btn-default">Batal</button>
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