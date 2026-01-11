<a href="<?=base_url('hitungan_turbine')?>"class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"> </span> Kembali</a>

<?php
// Mendefinisikan array nama-nama hari dalam bahasa Indonesia
$nama_hari = array(
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
);

// Mendapatkan nama hari dalam bahasa Indonesia
$nama_hari_indonesia = $nama_hari[date('l', strtotime($energies->time))];

// Format tanggal dengan nama hari dalam bahasa Indonesia
$tanggal_indonesia = date('d-F-Y', strtotime($energies->time));

// Menampilkan tanggal dengan format yang diminta (hari, tanggal bulan tahun)
?>
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          <div class="box-header">
          
          <h3 class='box-title'> Tanggal : <?= $nama_hari_indonesia ?>, <?=$tanggal_indonesia ?></h3> 
        </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>TIME</th>
                  <th>kWh Synchro</th>
                  <th>Turbine</th>
                  <th>Hasil Turbine</th>
                  <th>PLN</th>
                  <th>Hasil PLN</th>
                  <!-- <th>AKSI</th> -->
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>07:00</td>
                  <td>input di tanggal lalu</td>
                  <td>input di tanggal lalu</td> 
                  <td>input di tanggal lalu</td>
                  <td>input di tanggal lalu</td>
                  <td>input di tanggal lalu</td>
                </tr>
                <tr>
                  <td>15:00</td>
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh Synchro"></td>
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh Turbine"></td>
                  <td>1</td>
                  
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh PLN"></td>
                  <td>1</td>
                  <!-- <td> <button type="button" class="btn btn-success">simpan</button></td> -->

                </tr>
                <tr>
                  <td>23:00</td>
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh Synchro"></td>
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh Turbine"></td>
                  <td>1</td>
                  
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh PLN"></td>
                  <td>1</td>
                  <!-- <td> <button type="button" class="btn btn-success">simpan</button></td> -->


                </tr>
                <tr>
                  <td>07:00</td>
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh Synchro"></td>
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh Turbine"></td>
                  <td>1</td>
                  
                  <td><input type="number" class="form-control"  placeholder="Masukan kWh PLN"></td>
                  <td>1</td>
                  <!-- <td> <button type="button" class="btn btn-success">simpan</button></td> -->

                </tr>
                
                </tbody>
              </table>
              <button type="button" class="btn btn-success">simpan</button>

            </div>
          </div>
          

        </div>
      </div>

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Jumlah berapa jam operasi</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>TURBINE</label>
                <input type="number" class="form-control"  placeholder="Jumlah Total Jam Operasi Turbine">
              </div>
            </div>
           
            <div class="col-md-4">
              <div class="form-group">
                <label>SYNCHRO</label>
                <input type="number" class="form-control"  placeholder="Jumlah Total Jam Operasi Synchro">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>PLN</label>
                <input type="number" class="form-control"  placeholder="Jumlah Total Jam Operasi PLN">
              </div>
            </div>

          </div>
          <!-- /.row --><button type="button" class="btn btn-success">simpan</button>
        </div>
        
      </div>
      <!-- /.box -->

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Hasil kW</h3>
              <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table  class="table table-bordered table-hover">
                <thead>
                <tr>
                 <th>Hasil</th>
                  <th>Turbine</th>

                  <th>Synchro</th>
                  <th>PLN</th>
                 
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Average</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                </tr>

                <tr>
                  <td>Hari/Day</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                </tr>
                <tr>
                <td>Bulan/Month</td>
                <td>1</td>
                  <td>1</td>
                  <td>1</td>
                </tr>
             
                </tbody>
               
              </table>
            </div>
          </div>
        </div>
      </div>