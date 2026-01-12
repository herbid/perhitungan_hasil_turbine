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
                  <?php echo date('j F, Y ', strtotime($value->time)); ?></td>
                  <td><span class="label label-danger" style="font-size: 14px;">Belum Di Isi</span></td>
                  <td><span class="label label-danger" style="font-size: 14px;">Belum Di Isi</span></td>
                  <td> <span class="label label-danger" style="font-size: 14px;">Belum Di Isi</span></td>
                  <td>
                  <a href="<?php echo base_url('hitungan_turbine/mulai_hitung/' . $value->id_energy); ?>" class="btn btn-warning">Edit</a>
                       <button type="button" class="btn btn-info">Detail</button>
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
                  <span aria-hidden="true">&times;</span></button>
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
              <h4 class="modal-title">Hapus <?= $value->time ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

            <h2>Anda Yakin Untuk Menghapus Hapus <?= $value->time ?> !!! </h2>	

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

          <!-- Add this script at the end of your view --><script>
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

            // Close the modal
            $('#modal-hitung').modal('hide');

            // Redirect to a different page if needed
            if (response.success) {
                // Ambil id_energy dari respons server
                var idEnergy = response.id_energy;
                // Arahkan ke halaman mulai_hitung dengan menyertakan id_energy
                window.location.href = "<?php echo base_url('hitungan_turbine/mulai_hitung/') ?>" + idEnergy;
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        },
        complete: function() {
            // Re-enable the button after the request is complete
            $('button').prop('disabled', false);
        }
    });
}

</script>