 <!-- Main content -->


                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                
                            <p>Produksi Turbine</p>
                            <h3><?php echo sprintf('%.3f', $day_turbine ?: 0); ?><sup style="font-size: 20px">  kWh</sup></h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-nuclear"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                            <p>Export PLN</p>
                            <h3><?php echo sprintf('%.3f', $day_pln ?: 0); ?><sup style="font-size: 20px">  kWh</sup></h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-flash"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-orange-active">
                            <div class="inner">
                                <p>Operasi Turbine</p>
                            <h3><?php echo ($jam_operasi_turbine ?: 0); ?><sup style="font-size: 20px">Jam</sup></h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-time"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                   <p> Rata-Rata Turbine/Hours</p>
                            <h3><?php echo sprintf('%.1f', $avg_operasi_turbine ?: 0); ?><sup style="font-size: 20px">MWh</sup></h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-speedometer"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->


                 <section class="content">
  
      <div class="row">
        
        <!-- /.col -->

        <div class="col-md-6">
          <!-- Bar chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Produksi Turbine</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="bar-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->

          
          <!-- /.box -->
        </div>

        <div class="col-md-6">
          <!-- Line chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Export PLN</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="line-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->

          
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

   
 