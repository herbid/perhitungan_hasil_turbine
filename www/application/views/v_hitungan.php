<?php
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tanggal){
    $bulan = array (
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $hari = array (
        1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
    );
    
    $pecahkan = explode('-', $tanggal);
    
    // $pecahkan[0] = tanggal
    // $pecahkan[1] = bulan
    // $pecahkan[2] = tahun
    
    // Mendapatkan nama hari berdasarkan tanggal sekarang
    $numHari = date('N', strtotime($tanggal));
    
    return $hari[$numHari] . ', ' . $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[2];
}
// Contoh Penggunaan:
?>
<div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Data Table With Full Features</h3><br> -->
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-hitung"><span class="glyphicon glyphicon-plus"> </span>
              Tambah
              </button>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    
                <tr>
                    
                  <th>Tanggal</th>
                  <th>Shift Pagi</th>
                  <th>Shift Sore</th>
                  <th>Shift Malam</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($energy as $key => $value): ?>
                  
                <tr>
                <td data-order="<?php echo $value->time; ?>">
                  <?php echo tgl_indo(date('d-m-Y ', strtotime($value->time))); ?></td>
                  <td>
                    <?php 
                      $numHari = date('N', strtotime($value->time));
                      // Rabu = 3
                      if ($numHari == 3) {
                        // Shift Pagi untuk Rabu menggunakan id_jam_19
                        if ($value->kwh_synchro_19 != 0): ?>
                          <span class="label label-success" style="font-size: 14px;">Sudah Terisi</span>
                        <?php else: ?>
                          <span class="label label-danger" style="font-size: 14px;">Belum Di Isi</span>
                        <?php endif;
                      } else {
                        // Hari selain Rabu menggunakan id_jam_15
                        if ($value->kwh_synchro_15 != 0): ?>
                          <span class="label label-success" style="font-size: 14px;">Sudah Terisi</span>
                        <?php else: ?>
                          <span class="label label-danger" style="font-size: 14px;">Belum Di Isi</span>
                        <?php endif;
                      }
                    ?>
                  </td>
                  <td>
                    <?php 
                      $numHari = date('N', strtotime($value->time));
                      // Sembunyikan Shift Sore untuk Rabu
                      if ($numHari != 3): ?>
                        <?php if ($value->kwh_synchro_23 != 0): ?>
                          <span class="label label-success" style="font-size: 14px;">Sudah Terisi</span>
                        <?php else: ?>
                          <span class="label label-danger" style="font-size: 14px;">Belum Di Isi</span>
                        <?php endif; 
                      else: ?>
                        <span class="label label-secondary" style="font-size: 14px;">-</span>
                      <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($value->kwh_synchro_07 != 0): ?>
                      <span class="label label-success" style="font-size: 14px;">Sudah Terisi</span>
                    <?php else: ?>
                      <span class="label label-danger" style="font-size: 14px;">Belum Di Isi</span>
                    <?php endif; ?>
                  </td>
                  <td>
                  <a href="<?php echo base_url('hitungan_turbine/mulai_hitung/' . $value->id_energy); ?>" class="btn btn-warning">Edit</a>
                       <button type="button" class="btn btn-info" data-toggle="modal" 
                       data-target="#detail<?= $value->id_energy ?>">Detail</button>
                       
                       <button type="button" class="btn btn-danger" data-toggle="modal"
							         data-target="#delete<?= $value->id_energy ?>">Hapus</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>


<!-- /.modal pilih tanggal -->
          <div class="modal fade" id="modal-hitung">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Hitung Tanggal Berapa?</h4>
              </div>

              <div class="modal-body">
                 <!-- Date -->
              <div class="form-group">
                <label>Date:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="tanggal" id="datepicker">
                  </div>
                <!-- /.input group -->
              <!-- /.form group -->
              </div>

              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="saveDate()"><span class="glyphicon glyphicon-arrow-right"></span> Lanjut Hitung</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


      <!-- /.modal hapus -->
      <?php foreach ($energy as $key => $value) { ?>
      <div class="modal fade" id="delete<?= $value->id_energy ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Hapus Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

            <h2>Anda Yakin Untuk Menghapus :</h2>	
            <h1 style="color: #FF5733;"><?= tgl_indo(date('d-m-Y ', strtotime($value->time))); ?> !!! </h1> 
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <a href="<?=base_url('hitungan_turbine/delete/' . $value->id_energy) ?>" class="btn btn-primary">Hapus</a>


            </div>
          
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <?php } ?>

  <!-- /.modal detail -->
      <?php foreach ($energy as $key => $value) { ?>
      <div class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" id="detail<?= $value->id_energy ?>">
        <div class="modal-dialog modal-lg ">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Detail Data</h4>
          </div>
            <div class="modal-body">
     <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Time</th>
              <th>kWh Synchro</th>
              <th>kWh Turbine</th>
              <th>Hasil Turbine</th>
              <th>kWh PLN</th>
              <th>Hasil PLN</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Ambil detail data dari array yang sudah di-pass dari controller
            $numHari = date('N', strtotime($value->time));
            $detail_data = isset($energy_details[$value->id_energy]) ? $energy_details[$value->id_energy] : null;
            if ($numHari != 3): 
                echo "<tr>";
                echo "<td>15:00</td>"; // No
                echo "<td>" . ($detail_data && $detail_data->kwh_synchro_15 ? $detail_data->kwh_synchro_15 : 0) . "</td>";
                echo "<td>" . ($detail_data && $detail_data->kwh_turbine_15 ? $detail_data->kwh_turbine_15 : 0) . "</td>"; // Kolom 2
                echo "<td>" . ($detail_data && $detail_data->hasil_turbine_15 ? sprintf('%.3f', $detail_data->hasil_turbine_15) : 0) . "</td>"; // Kolom 3
                echo "<td>" . ($detail_data && $detail_data->kwh_pln_15 ? $detail_data->kwh_pln_15 : 0) . "</td>"; // Kolom 4
                echo "<td>" . ($detail_data && $detail_data->hasil_pln_15 ? sprintf('%.3f', $detail_data->hasil_pln_15) : 0) . "</td>"; // Kolom 5
                echo "</tr>";

                 echo "<tr>";
                echo "<td>23:00</td>"; // No
                echo "<td>" . ($detail_data && $detail_data->kwh_synchro_23 ? $detail_data->kwh_synchro_23 : 0) . "</td>"; // Kolom 1
                echo "<td>" . ($detail_data && $detail_data->kwh_turbine_23 ? $detail_data->kwh_turbine_23 : 0) . "</td>"; // Kolom 2
                echo "<td>" . ($detail_data && $detail_data->hasil_turbine_23 ? sprintf('%.3f', $detail_data->hasil_turbine_23) : 0) . "</td>"; // Kolom 3
                echo "<td>" . ($detail_data && $detail_data->kwh_pln_23 ? $detail_data->kwh_pln_23 : 0) . "</td>"; // Kolom 4
                echo "<td>" . ($detail_data && $detail_data->hasil_pln_23 ? sprintf('%.3f', $detail_data->hasil_pln_23) : 0) . "</td>"; // Kolom 5
                echo "</tr>";
                else:
                  echo "<tr>";
                echo "<td>19:00</td>"; // No
                echo "<td>" . ($detail_data && $detail_data->kwh_synchro_19 ? $detail_data->kwh_synchro_19 : 0) . "</td>"; // Kolom 1
                echo "<td>" . ($detail_data && $detail_data->kwh_turbine_19 ? $detail_data->kwh_turbine_19 : 0) . "</td>"; // Kolom 2
                echo "<td>" . ($detail_data && $detail_data->hasil_turbine_19 ? sprintf('%.3f', $detail_data->hasil_turbine_19) : 0) . "</td>"; // Kolom 3
                echo "<td>" . ($detail_data && $detail_data->kwh_pln_19 ? $detail_data->kwh_pln_19 : 0) . "</td>"; // Kolom 4
                echo "<td>" . ($detail_data && $detail_data->hasil_pln_19 ? sprintf('%.3f', $detail_data->hasil_pln_19) : 0) . "</td>"; // Kolom 5
                echo "</tr>";
                endif ;
                 echo "<tr>";
                echo "<td>07:00</td>"; // No
                echo "<td>" . ($detail_data && $detail_data->kwh_synchro_07 ? $detail_data->kwh_synchro_07 : 0) . "</td>"; // Kolom 1
                echo "<td>" . ($detail_data && $detail_data->kwh_turbine_07 ? $detail_data->kwh_turbine_07 : 0) . "</td>"; // Kolom 2
                echo "<td>" . ($detail_data && $detail_data->hasil_turbine_07 ? sprintf('%.3f', $detail_data->hasil_turbine_07) : 0) . "</td>"; // Kolom 3
                echo "<td>" . ($detail_data && $detail_data->kwh_pln_07 ? $detail_data->kwh_pln_07 : 0) . "</td>"; // Kolom 4
                echo "<td>" . ($detail_data && $detail_data->hasil_pln_07 ? sprintf('%.3f', $detail_data->hasil_pln_07) : 0) . "</td>"; // Kolom 5
                echo "</tr>";
           
            ?>
            <thead>
            <tr>
              <th colspan="2">Jumlah operasi Turbine</th>
              <th colspan="2">Jumlah operasi Synchro</th>
              <th colspan="2">jumlah operasi PLN</th>
            </tr>
          </thead>
           <tr>
              <th colspan="2"><?php echo ($detail_data && $detail_data->turbine_jam ? $detail_data->turbine_jam : 0); ?> Jam </th>
              <th colspan="2"><?php echo ($detail_data && $detail_data->synchro_jam ? $detail_data->synchro_jam : 0); ?> Jam</th>
              <th colspan="2"><?php echo ($detail_data && $detail_data->pln_jam ? $detail_data->pln_jam : 0); ?> Jam</th>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Hasil</th>
              <th>Turbine</th>
              <th>Synchro</th>
              <th>PLN</th>
            </tr>
          </thead>
          <tbody>
           <?php
                echo "<tr>";
                echo "<td>Average</td>"; // No
                echo "<td>" . ($detail_data && $detail_data->avg_turbine ? sprintf('%.3f', $detail_data->avg_turbine) : 0) . "</td>"; // Kolom 1
                echo "<td>" . ($detail_data && $detail_data->avg_synchro ? sprintf('%.3f', $detail_data->avg_synchro) : 0) . "</td>"; // Kolom 2
                echo "<td>" . ($detail_data && $detail_data->avg_pln ? sprintf('%.3f', $detail_data->avg_pln) : 0) . "</td>"; // Kolom 3
                
                echo "</tr>";

                 echo "<tr>";
                echo "<td>Hari/Day</td>"; // No
                echo "<td>" . ($detail_data && $detail_data->day_turbine ? sprintf('%.3f', $detail_data->day_turbine) : 0) . "</td>"; // Kolom 1
                echo "<td>" . ($detail_data && $detail_data->day_synchro ? sprintf('%.3f', $detail_data->day_synchro) : 0) . "</td>"; // Kolom 2
                echo "<td>" . ($detail_data && $detail_data->day_pln ? sprintf('%.3f', $detail_data->day_pln) : 0) . "</td>"; // Kolom 3
                
                echo "</tr>";
                
                 echo "<tr>";
                echo "<td>Bulan/Month</td>"; // No
                echo "<td>" . ($detail_data && $detail_data->month_turbine ? sprintf('%.3f', $detail_data->month_turbine) : 0) . "</td>"; // Kolom 1
                echo "<td>" . ($detail_data && $detail_data->month_synchro ? sprintf('%.3f', $detail_data->month_synchro) : 0) . "</td>"; // Kolom 2
                echo "<td>" . ($detail_data && $detail_data->month_pln ? sprintf('%.3f', $detail_data->month_pln) : 0) . "</td>"; // Kolom 3
            
                echo "</tr>";
           
            ?>
          </tbody>
        </table>

             
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>


            </div>
          
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <?php } ?>

          <!-- Add this script at the end of your view -->
           <script>
    function saveDate() {
    var selectedDate = $('#datepicker').val();

    // Validasi apakah tanggal sudah diisi
    if (!selectedDate) {
        alert("Tanggal harus diisi");
        return;
    }

    // Prevent further interactions during the AJAX request
    $('button').prop('disabled', true);

    $.ajax({
        type: "POST",
        url: "<?php echo base_url('hitungan_turbine/tambah_hitungan'); ?>",
        data: {tanggal: selectedDate},
        dataType: 'json',
        // Inside the success callback
        success: function(response) {
            console.log(response);

            if (response.success) {
                // Close the modal
                $('#modal-hitung').modal('hide');
                
                // Ambil id_energy dari respons server
                var idEnergy = response.id_energy;
                // Arahkan ke halaman mulai_hitung dengan menyertakan id_energy
                window.location.href = "<?php echo base_url('hitungan_turbine/mulai_hitung/') ?>" + idEnergy;
            } else {
                // Tampilkan pesan error jika ada
                alert(response.error || 'Terjadi kesalahan saat menyimpan tanggal');
                // Re-enable button setelah error
                $('button').prop('disabled', false);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Parse error response dari server
            try {
                var response = JSON.parse(xhr.responseText);
                alert(response.error || 'Terjadi kesalahan');
            } catch(e) {
                alert('Terjadi kesalahan pada server');
            }
            // Re-enable button setelah error
            $('button').prop('disabled', false);
        },
        complete: function() {
            // Re-enable the button after the request is complete (jika belum di-enable di error/success)
        }
    });
}

</script>