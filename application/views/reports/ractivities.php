<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$name = $this->session->userdata('SESS_USER_ID'); ?>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#txtdate1, #txtdate2").each(function() {
            $(this).datepicker({
                autoclose: true,
                format: "dd-mm-yyyy"
            });
        });
        
        $("#txtuserid").select2({
            placeholder: "Data Anggota",
            minimumInputLength: 0,
            ajax: {
                url: "<?php echo base_url();?>settings/combouser",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    return {
                        txtkey: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.items, function(item) {
                            return {
                                text: item.nama,
                                id: item.userid
                            }
                        }),
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
            templateResult: function(element){                
                if (element.loading) return element.text;
                return element.text;
            },
            templateSelection: function(element){
                return element.text;
            },
            escapeMarkup: function(m) {
                return m;
            }
        });
        
        $("button[name=btnlaporan]").on("click", function(e) 
        {
            var formData = new FormData($("form")[1]);
            
            $.ajax({
                type: "post",
                dataType: "html",
                url: "<?php echo base_url();?>reports/reportractivities",
                data: formData,
                beforeSend: function() {
                    $(".content-wrapper").html("");
                },
                success: function(content) {
                    $(".content-wrapper").html(content);
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
        
        <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'L4', 'edit') == 'N'):?>
			$("input:text").attr("disabled", true).css({"background-color": "#ECE9D8", "color": "#ACA899", "font-style": "italic"});
			$("button[name=btnsimpan]").attr("disabled", true);
            $("button[name=btnsimpan]").focus();
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
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-file-text-o margin-r-5"></i><?php echo $caption?></h3>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" role="form" method="post" action="#" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtdate" class="col-sm-3 control-label">Tanggal</label>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control" id="txtdate1" name="txtdate1" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control" id="txtdate2" name="txtdate2" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtformat" class="col-sm-3 control-label">Nama Pengguna</label>
                            <div class="col-sm-9"><select class="form-control" name="txtuserid" id="txtuserid">
                                <option value="">Search...</option>
                            </select></div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button name="btnlaporan" type="submit" class="btn bg-<?php echo $this->config->item('site_theme');?> visible-btn-lg"><i class="fa fa-file-o"></i><span class="inline-block margin-l-5 hidden-xs">Laporan</span></button>
                        <button name="btnbatal" type="reset" class="btn btn-default hidden-xs"><i class="fa fa-remove margin-r-5"></i>Tutup</button>
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