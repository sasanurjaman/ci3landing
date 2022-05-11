<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Dashboard<small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="<?php echo $logo;?>"></i> <?php echo $mainpage;?></a></li>
        <?php if ($caption != ""):?>
            <li class="active">Dashboard</li>
        <?php endif?>
    </ol>
</section>
                
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo $datacount1;?></h3>
                    <p>Berita</p>
                </div>
                <div class="icon"><i class="ion ion-person-add"></i></div>
                <a href="<?php echo base_url();?>transactions/news" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo $datacount2;?></h3>
                    <p>Video</p>
                </div>
                <div class="icon"><i class="ion ion-person-stalker"></i></div>
                <a href="<?php echo base_url();?>transactions/video" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo $datacount3;?></h3>
                    <p>Agenda</p>
                </div>
                <div class="icon"><i class="ion ion-compose"></i></div>
                <a href="<?php echo base_url();?>transactions/agenda" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $datacount4;?></h3>
                    <p>Abensi</p>
                </div>
                <div class="icon"><i class="ion ion-cash"></i></div>
                <a href="<?php echo base_url();?>transactions/absensi" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        
    </div>
    <!-- /.row -->
    
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-body">
                    <div class="col-xs-12" style="padding:28px;">
                        <center>
                            <h4 style="margin-top:0;"><?php echo day2ina().', '.date('d').' '.month2ina().' '.date('Y');?></h4>
                            <h2 class="runTime" style="margin-top:0;margin-bottom:20px">&nbsp;</h2>
                            <img src="<?php echo base_url().'images/'.(getCompany()->logo != '-' ? getCompany()->logo : $this->config->item('site_logo'));?>" border="0" width="128" height="128">
                            <h4><?php echo (getCompany()->nama != '-' ? getCompany()->nama : $this->config->item('site_name').' '.$this->config->item('site_version'));?></h4>
                            <h5 style="color:#ff0000;"><?php echo (getCompany()->moto != '-' ? getCompany()->moto : $this->config->item('site_longname'));?></h5>
                        </center>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Left col -->
        <section class="col-lg-5 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-<?php echo $this->config->item('site_theme');?>">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i><h3 class="box-title">Aktifitas Terakhir</h3>
                    <div class="box-tools pull-right">
                        <ul class="pagination pagination-sm inline">
                            <li><a href="#">&laquo;</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.box-header -->
                
                <div class="box-body">
                    <ul class="todo-list">
                        <?php if(isset($datalog) and $datalog != false): $i = 1;?>
                            <?php foreach ($datalog as $row):?>
                                <li>
                                    <span class="text"><?php echo '['.$row->tanggal.'] '.$row->keterangan;?></span>
                                </li>
                            <?php $i++; endforeach;?>
                            <?php for ($j = $i; $j <= 7; $j++):?>
                                <li>
                                    <span class="text">&nbsp;</span>
                                </li>
                            <?php endfor;?>	
                        <?php endif;?>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
    </div>
    <!-- /.row -->
</section>