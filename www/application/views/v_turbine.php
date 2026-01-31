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

// menampilakan data id yang di klik dan data ida sebelumnya 
$current_data  = isset($combined_data[0]) ? $combined_data[0] : null;
$previous_data = isset($combined_data[1]) ? $combined_data[1] : null;

// Ambil tanggal hari ini dari data (misal: "01", "05", "31")
$tanggal_saat_ini = date('d', strtotime($energies->time));

// Variabel untuk menyimpan akumulasi bulan lalu (Data Excel baris sebelumnya)
$akumulasi_sebelumnya = 0;

if ($tanggal_saat_ini == '01') {
    // KONDISI TANGGAL 1: 
    // Di Excel baris pertama, tidak ada penjumlahan dengan baris atasnya.
    // Jadi akumulasi start dari 0.
    $akumulasi_sebelumnya = 0; 
} else {
    // KONDISI TANGGAL > 1 (Tanggal 2, 3, dst):
    // Kita ambil data 'month_turbine' dari database tanggal kemarin ($previous_data)
    // Ini sama dengan mengambil sel H14 pada gambar Excel Anda
    $akumulasi_sebelumnya = $previous_data->month_turbine ?? 0;
}
?>
  <div class="box-tools pull-right">
                <!-- ID ENERGY UNTUK UPDATE -->
              <input type="hidden" id="id_energy" value="<?= $energies->id_energy ?>">
             <button type="button" id="simpan_turbine" class="btn btn-success"> Simpan <span class="fa fa-save"> </span></button>
          </div>
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          <div class="box-header">
        
          <h3 class='box-title'>
          Tanggal: <?= isset($energies->time) ? $nama_hari_indonesia . ', ' . $tanggal_indonesia : 'Data tidak tersedia'; ?>
        </h3>    
            
        </div>

            <!-- /.box-header -->
            <div class="box-body"> <table class="table table-bordered table-hover"> 
  
  
            
            <thead> 
                <tr> 
                  <th>TIME</th>
                   <th>kWh Synchro</th>
                    <th>kWh Turbine</th> 
                    <th>Hasil Turbine</th> 
                    <th>kWh PLN</th> 
                    <th>Hasil PLN</th> 
                    <!-- <th>AKSI</th> --> 
                    </tr> 
                  </thead> 
                  <tbody>
                <tr>
                  <td>07:00</td>
                  <td><?= $previous_data->kwh_synchro_07 ?: '-'; ?></td>
                  <td><?= $previous_data->kwh_turbine_07 ?: '-'; ?></td>
                  <td></td>
                  <td><?= $previous_data->kwh_pln_07 ?: '-'; ?></td>
                  <td></td>
               </tr>
              <?php if($nama_hari_indonesia != 'Rabu'): ?>
                 <!-- TAMPILKAN 15:00 dan 23:00 jika bukan Rabu -->
                <tr>
                  <td>15:00</td>
                  <td><input type="number" name="Synchro_15" class="form-control"  placeholder="Masukan kWh Synchro" value="<?= $current_data->kwh_synchro_15 ?? '' ?>"></td>                  
                  <td><input type="number" name="Turbine_15" class="form-control"  placeholder="Masukan kWh Turbine" value="<?= $current_data->kwh_turbine_15 ?? '' ?>"></td>
                  <td data-hasil="hasil_turbine_15"><?= $current_data->hasil_turbine_15 ?? '' ?></td>
                  
                  <td><input type="number" name="PLN_15" class="form-control"  placeholder="Masukan kWh PLN" value="<?= $current_data->kwh_pln_15 ?? '' ?>"></td>
                  <td data-hasil="hasil_pln_15"><?= $current_data->hasil_pln_15 ?? '' ?></td>
                  <!-- <td> <button type="button" class="btn btn-success">simpan</button></td> -->

                </tr>
                <tr>
                  <td>23:00</td>
                  <td><input type="number" name="Synchro_23" class="form-control"  placeholder="Masukan kWh Synchro" value="<?= $current_data->kwh_synchro_23 ?? '' ?>"></td>
                  <td><input type="number" name="Turbine_23" class="form-control"  placeholder="Masukan kWh Turbine" value="<?= $current_data->kwh_turbine_23 ?? '' ?>"></td>
                  <td data-hasil="hasil_turbine_23"><?= $current_data->hasil_turbine_23 ?? '' ?></td>
                  
                  <td><input type="number" name="PLN_23" class="form-control"  placeholder="Masukan kWh PLN" value="<?= $current_data->kwh_pln_23 ?? '' ?>"></td>
                  <td data-hasil="hasil_pln_23"><?= $current_data->hasil_pln_23 ?? '' ?></td>
                  <!-- <td> <button type="button" class="btn btn-success">simpan</button></td> -->
                </tr>
             <?php else: ?>
                  <!-- KHUSUS HARI RABU: TAMPILKAN JAM 19 SAJA -->

                  <tr>
                    <td>19:00</td>
                    <td><input type="number" name="Synchro_19" class="form-control" placeholder="Masukan kWh Synchro" value="<?= $current_data->kwh_synchro_19 ?? '' ?>"></td>
                    <td><input type="number" name="Turbine_19" class="form-control" placeholder="Masukan kWh Turbine" value="<?= $current_data->kwh_turbine_19 ?? '' ?>"></td>
                    <td data-hasil="hasil_turbine_19"><?= $current_data->hasil_turbine_19 ?? '' ?></td>
                    <td><input type="number" name="PLN_19" class="form-control" placeholder="Masukan kWh PLN" value="<?= $current_data->kwh_pln_19 ?? '' ?>"></td>
                    <td data-hasil="hasil_pln_19"><?= $current_data->hasil_pln_19 ?? '' ?></td>
                  </tr>

            <?php endif; ?>
                <tr>
                  <td>07:00</td>
                  <td><input type="number" name="Synchro_07" class="form-control"  placeholder="Masukan kWh Synchro" value="<?= $current_data->kwh_synchro_07 ?? '' ?>"></td>
                  <td><input type="number" name="Turbine_07" class="form-control"  placeholder="Masukan kWh Turbine" value="<?= $current_data->kwh_turbine_07 ?? '' ?>"></td>
                  <td data-hasil="hasil_turbine_07"><?= $current_data->hasil_turbine_07 ?? '' ?></td>

                  <td><input type="number" name="PLN_07" class="form-control"  placeholder="Masukan kWh PLN" value="<?= $current_data->kwh_pln_07 ?? '' ?>"></td>
                  <td data-hasil="hasil_pln_07"><?= $current_data->hasil_pln_07 ?? '' ?></td>
                  <!-- <td> <button type="button" class="btn btn-success">simpan</button></td> -->

                </tr>
                
                </tbody>
              </table>
             

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
                <input type="number" name="jam_operasi_turbine" class="form-control"  placeholder="Jumlah Total Jam Operasi Turbine" value="<?= $current_data->turbine_jam ?? '' ?>">
              </div>
            </div>
           
            <div class="col-md-4">
              <div class="form-group">
                <label>SYNCHRO</label>
                <input type="number" name="jam_operasi_synchro" class="form-control"  placeholder="Jumlah Total Jam Operasi Synchro" value="<?= $current_data->synchro_jam ?? '' ?>">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>PLN</label>
                <input type="number" name="jam_operasi_pln" class="form-control"  placeholder="Jumlah Total Jam Operasi PLN" value="<?= $current_data->pln_jam ?? '' ?>">
              </div>
            </div>

          </div>
          <!-- /.row -->
        </div>
        
      </div>
      <!-- /.box -->

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Hasil kWh</h3>
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
                  <td data-hasil="hasil_avg_turbine"><?= number_format($current_data->avg_turbine ?? 0, 3, ',', '.') ?></td>
                  <td data-hasil="hasil_avg_synchro"><?= number_format($current_data->avg_synchro ?? 0, 3, ',', '.') ?></td>
                  <td data-hasil="hasil_avg_pln"><?= number_format($current_data->avg_pln ?? 0, 3, ',', '.') ?></td>
                </tr>
                
                <tr>
                  <td>Hari/Day</td>
                  <td data-hasil="hasil_day_turbine"><?= number_format($current_data->day_turbine ?? 0, 3, ',', '.') ?></td>
                  <td data-hasil="hasil_day_synchro"><?= number_format($current_data->day_synchro ?? 0, 3, ',', '.') ?></td>
                  <td data-hasil="hasil_day_pln"><?= number_format($current_data->day_pln ?? 0, 3, ',', '.') ?></td>
                </tr>

                 <input type="hidden" id="data_akumulasi_sebelumnya" value="<?= $akumulasi_sebelumnya ?>">
                  <tr>
                      <td>Bulan/Month</td>
                      <td data-hasil="hasil_month_turbine"></td>
                      <td data-hasil="hasil_month_synchro"></td>
                      <td data-hasil="hasil_month_pln"></td>
                  </tr>
             
                </tbody>
               
              </table>
            </div>
          </div>
        </div>
      </div>
      
<script>

document.addEventListener("DOMContentLoaded", function() {
  try {
const isRabu = "<?= $nama_hari_indonesia ?>" === "Rabu";
  // Fungsi bantu: ubah nilai string jadi angka yang benar
  function toNumber(value) {
    if (!value) return NaN;
    // Ganti koma jadi titik biar bisa dibaca parseFloat
    return parseFloat(value.replace(",", "."));
  }

  // Fungsi bantu: ubah hasil float jadi string dengan koma
  function toCommaFormat(number, decimals = 2) {
    if (isNaN(number)) return "-";
    // Ubah ke format angka Indonesia (titik ribuan, koma desimal)
    return number.toLocaleString("id-ID", {
      minimumFractionDigits: decimals,
      maximumFractionDigits: decimals
    });
  }

  // Format semua nilai hasil yang dimuat dari database
  function formatAllResults() {
    const hasilElements = document.querySelectorAll('[data-hasil]');
    hasilElements.forEach(el => {
      const value = el.textContent.trim();
      if (value && value !== '0' && value !== '-') {
        const numValue = toNumber(value);
        if (!isNaN(numValue)) {
          el.textContent = toCommaFormat(numValue, 3);
        }
      }
    });
  }

  // Jalankan format saat halaman dimuat
  formatAllResults();

// -----------------------------
// ====== TURBINE JAM 19:00 ====
// -----------------------------
if (isRabu) {
const input_Turbine_jam19 = document.querySelector('input[name="Turbine_19"]');
const hasil_Turbine_jam19 = document.querySelector("[data-hasil='hasil_turbine_19']");
const tampungan_turbine_jam07_sebelumnya = toNumber("<?= $previous_data->kwh_turbine_07 ?? 0 ?>");


  input_Turbine_jam19.addEventListener("input", function() {
    const nilai_19 = toNumber(this.value);
    if (!isNaN(nilai_19)) {
      const result = (nilai_19 - tampungan_turbine_jam07_sebelumnya) / 10;
      hasil_Turbine_jam19.textContent = toCommaFormat(result, 3);
    } else {
      hasil_Turbine_jam19.textContent = "-";
    }
  });


// -----------------------------
// ====== PLN JAM 19:00 =======
// -----------------------------
const input_PLN_jam19 = document.querySelector('input[name="PLN_19"]');
const hasil_PLN_jam19 = document.querySelector("[data-hasil='hasil_pln_19']");
const tampungan_pln_jam07_sebelumnya = toNumber("<?= $previous_data->kwh_pln_07 ?? 0 ?>");

  input_PLN_jam19.addEventListener("input", function() {
    const nilai_19 = toNumber(this.value);
    if (!isNaN(nilai_19)) {
      const result = (nilai_19 - tampungan_pln_jam07_sebelumnya) * 8;
      hasil_PLN_jam19.textContent = toCommaFormat(result, 3);
    } else {
      hasil_PLN_jam19.textContent = "-";
    }
  });
   
}else {

  // -----------------------------
  // ====== TURBINE JAM 15:00 ====
  // -----------------------------
  const input_Turbine_jam15 = document.querySelector('input[name="Turbine_15"]'); // kolom input kWh Turbine
  const hasil_Turbine_jam15 = document.querySelector("[data-hasil='hasil_turbine_15']");       // kolom hasil Turbine
  const tampungan_turbine_jam07_tglsebelumnya = toNumber("<?= $previous_data->kwh_turbine_07 ?? 0 ?>");

  input_Turbine_jam15.addEventListener("input", function() {
    const nilai_yang_di_input_turbine_jam15 = toNumber(this.value);
    if (!isNaN(nilai_yang_di_input_turbine_jam15)) {
      const result = (nilai_yang_di_input_turbine_jam15 - tampungan_turbine_jam07_tglsebelumnya) / 10;
      hasil_Turbine_jam15.textContent = toCommaFormat(result, 3);
    } else {
      hasil_Turbine_jam15.textContent = "-";
    }
  });

  // -----------------------------
  // ====== PLN JAM 15:00 ========
  
  // -----------------------------
  const input_PLN_jam15 = document.querySelector('input[name="PLN_15"]'); // kolom input kWh PLN
  const hasil_PLN_jam15 = document.querySelector('[data-hasil="hasil_pln_15"]');      // kolom hasil PLN
  const tampungan_pln_jam07_tglsebelumnya = toNumber("<?= $previous_data->kwh_pln_07 ?? 0 ?>");

  input_PLN_jam15.addEventListener("input", function() {
    const nilai_yang_di_input_pln_jam15 = toNumber(this.value);
    if (!isNaN(nilai_yang_di_input_pln_jam15)) {
      const result = (nilai_yang_di_input_pln_jam15 - tampungan_pln_jam07_tglsebelumnya) * 8;
      hasil_PLN_jam15.textContent = toCommaFormat(result, 3);
    } else {
      hasil_PLN_jam15.textContent = "-";
    }
  });

// -----------------------------
  // ====== TURBINE JAM 23:00 ====
  // -----------------------------

const input_Turbine_jam23 = document.querySelector('input[name="Turbine_23"]');
const hasil_Turbine_jam23 = document.querySelector('[data-hasil="hasil_turbine_23"]');
const tampungan_turbine_jam15sebelumnya = document.querySelector('input[name="Turbine_15"]');

// kalau user isi nilai di jam 23:00
  input_Turbine_jam23.addEventListener("input", function() {
    const nilai_23 = toNumber(this.value);
    const nilai_15 = toNumber(tampungan_turbine_jam15sebelumnya.value);

    if (!isNaN(nilai_23) && !isNaN(nilai_15)) {
      const result = (nilai_23 - nilai_15) / 10;
      hasil_Turbine_jam23.textContent = toCommaFormat(result, 3);
    } else {
      hasil_Turbine_jam23.textContent = "-";
    }
  });

// -----------------------------
  // ====== PLN JAM 23:00 ====
  // -----------------------------

const input_PLN_jam23 = document.querySelector('input[name="PLN_23"]');
const hasil_PLN_jam23 = document.querySelector('[data-hasil="hasil_pln_23"]');
const tampungan_PLN_jam15sebelumnya = document.querySelector('input[name="PLN_15"]');

// kalau user isi nilai di jam 23:00
  input_PLN_jam23.addEventListener("input", function() {
    const nilai_23 = toNumber(this.value);
    const nilai_15 = toNumber(tampungan_PLN_jam15sebelumnya.value);

    if (!isNaN(nilai_23) && !isNaN(nilai_15)) {
      const result = (nilai_23 - nilai_15) * 8;
      hasil_PLN_jam23.textContent = toCommaFormat(result, 3);
    } else {
      hasil_PLN_jam23.textContent = "-";
    }
  });
 }
  // -----------------------------
  // ====== TURBINE JAM 07:00 ====
  // -----------------------------

const input_Turbine_jam07 = document.querySelector('input[name="Turbine_07"]');
const hasil_Turbine_jam07 = document.querySelector('[data-hasil="hasil_turbine_07"]');

    input_Turbine_jam07.addEventListener("input", function() {
    const nilai_07 = toNumber(this.value);
    let val_sebelumnya = 0;
    if (isRabu) {
      val_sebelumnya = toNumber(document.querySelector('input[name="Turbine_19"]').value);
    } else {
      val_sebelumnya = toNumber(document.querySelector('input[name="Turbine_23"]').value);
    }
    if (!isNaN(nilai_07) && !isNaN(val_sebelumnya)) {
      const result = (nilai_07 - val_sebelumnya) / 10;
      hasil_Turbine_jam07.textContent = toCommaFormat(result, 3);
    } else {
      hasil_Turbine_jam07.textContent = "-";
    }
  });



// -----------------------------
  // ====== PLN JAM 07:00 ====
  // -----------------------------

const input_PLN_jam07 = document.querySelector('input[name="PLN_07"]');
const hasil_PLN_jam07 = document.querySelector('[data-hasil="hasil_pln_07"]');

// kalau user isi nilai di jam 23:00
  input_PLN_jam07.addEventListener("input", function() {
    const nilai_07 = toNumber(this.value);
    let val_sebelumnya = 0;
    if (isRabu) {
      val_sebelumnya = toNumber(document.querySelector('input[name="PLN_19"]').value);
    } else {
      val_sebelumnya = toNumber(document.querySelector('input[name="PLN_23"]').value);
    }
    if (!isNaN(nilai_07) && !isNaN(val_sebelumnya)) {
      const result = (nilai_07 - val_sebelumnya) * 8;
      hasil_PLN_jam07.textContent = toCommaFormat(result, 3);
    } else {
      hasil_PLN_jam07.textContent = "-";
    }
  });


//-------------- average  ----------------
// average turbine
const input_avg_turbine = document.querySelector('input[name="jam_operasi_turbine"]');
const total_day_turbine = document.querySelector('[data-hasil="hasil_day_turbine"]');

input_avg_turbine.addEventListener("input", function() {
    const jam_operasi_turbine = toNumber(this.value);
    const hasil_day_turbine = toNumber(total_day_turbine.textContent);

    if (!isNaN(jam_operasi_turbine) && jam_operasi_turbine > 0 && !isNaN(hasil_day_turbine)) {
      const avg_result = hasil_day_turbine / jam_operasi_turbine;
      const hasil_avg_turbine_elem = document.querySelector('[data-hasil="hasil_avg_turbine"]');
      hasil_avg_turbine_elem.textContent = toCommaFormat(avg_result, 3);
    } else {
      const hasil_avg_turbine_elem = document.querySelector('[data-hasil="hasil_avg_turbine"]');
      hasil_avg_turbine_elem.textContent = "-";
    }
  });

  // average synchro
const input_avg_synchro = document.querySelector('input[name="jam_operasi_synchro"]');
const total_day_synchro = document.querySelector('[data-hasil="hasil_day_synchro"]');

input_avg_synchro.addEventListener("input",function(){
  const jam_operasi_synchro= toNumber(this.value);
  const hasil_day_synchro = toNumber(total_day_synchro.textContent);

  if(!isNaN(jam_operasi_synchro) && jam_operasi_synchro >0 && !isNaN(hasil_day_synchro)){
    const avg_result = hasil_day_synchro / jam_operasi_synchro;
    const hasil_avg_synchro_elem = document.querySelector('[data-hasil="hasil_avg_synchro"]');
    hasil_avg_synchro_elem.textContent = toCommaFormat(avg_result,3);
  } else {
    const hasil_avg_synchro_elem = document.querySelector('[data-hasil="hasil_avg_synchro"]');
    hasil_avg_synchro_elem.textContent = "-";
  }
});

// average PLN
const input_avg_pln = document.querySelector('input[name="jam_operasi_pln"]');
const total_day_pln = document.querySelector('[data-hasil="hasil_day_pln"]');

input_avg_pln.addEventListener("input", function(){
const jam_operasi_pln = toNumber(this.value);
const hasil_day_pln = toNumber(total_day_pln.textContent);

if (!isNaN(jam_operasi_pln)&& jam_operasi_pln >0 && !isNaN(hasil_day_pln)) {
  const avg_result = hasil_day_pln / jam_operasi_pln;
  const hasil_avg_pln_elem = document.querySelector('[data-hasil="hasil_avg_pln"]');
  hasil_avg_pln_elem.textContent= toCommaFormat(avg_result,3);
}else{
  const hasil_day_pln_elem = document.querySelector('[data-hasil="hasil_avg_pln"]');
  hasil_day_pln_elem.textContent = "-";
}
})
//-------------- DAY  ----------------
// hari day turbine
const hasil_day_turbine_15 =  toNumber("<?= $current_data->hasil_turbine_15 ?? 0 ?>");
const hasil_day_turbine_23 =  toNumber("<?= $current_data->hasil_turbine_23 ?? 0 ?>");
const hasil_day_turbine_07 =  toNumber("<?= $current_data->hasil_turbine_07 ?? 0 ?>");  
const hasil_day_turbine_total = hasil_day_turbine_15 + hasil_day_turbine_23 + hasil_day_turbine_07;
const hasil_day_turbine_elem = document.querySelector('[data-hasil="hasil_day_turbine"]');
hasil_day_turbine_elem.textContent = toCommaFormat(hasil_day_turbine_total, 3);   

// hari day synchro
const day_synchro_07_before = toNumber("<?= $previous_data->kwh_synchro_07 ?? 0 ?>");
const day_synchro_07_after= toNumber("<?= $current_data->kwh_synchro_07 ?? 0 ?>");
const hasil_day_synchro_total = (day_synchro_07_after - day_synchro_07_before)*11454/1000;
const hasil_day_synchro_elem = document.querySelector('[data-hasil="hasil_day_synchro"]');
hasil_day_synchro_elem.textContent = toCommaFormat(hasil_day_synchro_total, 3); 

// hari day pln
const hasil_day_pln_15 =  toNumber("<?= $current_data->hasil_pln_15 ?? 0 ?>");
const hasil_day_pln_23 =  toNumber("<?= $current_data->hasil_pln_23 ?? 0 ?>");
const hasil_day_pln_07 =  toNumber("<?= $current_data->hasil_pln_07 ?? 0 ?>");  
const hasil_day_pln_total = hasil_day_pln_15 + hasil_day_pln_23 + hasil_day_pln_07;
const hasil_day_pln_elem = document.querySelector('[data-hasil="hasil_day_pln"]');
hasil_day_pln_elem.textContent = toCommaFormat(hasil_day_pln_total, 3);  


//-------------- MONTH  ----------------
// 1. Ambil "Data Kemarin" dari Hidden Input
// Jika tgl 1, ini isinya 0.
// Jika tgl 2, ini isinya nilai Month tgl 1 (misal 32.340).
const nilai_akumulasi_sebelumnya = parseFloat(document.getElementById('data_akumulasi_sebelumnya').value) || 0;

// 2. Ambil "Day Hari Ini" (hasil hitungan realtime)
// Pastikan variabel 'hasil_day_turbine_total' sudah dihitung di script Anda sebelumnya
const day_hari_ini = hasil_day_turbine_total; 

// 3. Rumus Penjumlahan
// Tanggal 1: 0 + Day Hari Ini = Day Hari Ini (Cocok dengan Excel baris 1)
// Tanggal 2: Nilai Kemarin + Day Hari Ini (Cocok dengan Excel baris 2 rumus H14+H27)
const total_month_turbine = nilai_akumulasi_sebelumnya + day_hari_ini;

// 4. Tampilkan ke Layar
const elemen_month_turbine = document.querySelector('[data-hasil="hasil_month_turbine"]');
if (elemen_month_turbine) {
    elemen_month_turbine.textContent = toCommaFormat(total_month_turbine, 3);
}

// ================================================================

} catch (err) {
    console.error('Inisialisasi JS error:', err);
  }
}); 

// ... (Kode perhitungan Anda sebelumnya tetap di sini) ...

// ==========================================
// KODE UNTUK TOMBOL SIMPAN (AJAX)
// ==========================================
// =======================================================
// SCRIPT SIMPAN DATA TURBINE (Versi Mudah Dibaca)
// =======================================================

document.addEventListener("DOMContentLoaded", function() {

    // 1. Ambil tombol simpan dari HTML
    const tombolSimpan = document.getElementById('simpan_turbine');

    // Jika tombol tidak ada (misal user tidak punya akses), hentikan script
    if (!tombolSimpan) return; 

    // 2. Apa yang terjadi saat tombol diklik?
    tombolSimpan.addEventListener('click', function() {
        prosesSimpanData();
    });
    // =======================================================
    // FUNGSI UTAMA: MENGUMPULKAN DAN MENGIRIM DATA
    // =======================================================
    function prosesSimpanData() {
        // A. Ambil ID Energy (Wajib ada)
        const idEnergy = document.getElementById('id_energy').value;

        // B. Siapkan wadah data yang akan dikirim
        let dataKirim = {
            id_energy: idEnergy
        };

        // C. Ambil data per jam menggunakan "Fungsi Bantu" (lihat di bawah)
        // Logikanya: Kita cek satu per satu, kalau ada datanya, masukkan ke wadah.
        
        let dataJam15 = ambilDataPerJam('15');
        if (dataJam15) {
            dataKirim.jam_15 = dataJam15;
        }

        let dataJam23 = ambilDataPerJam('23');
        if (dataJam23) {
            dataKirim.jam_23 = dataJam23;
        }

        let dataJam19 = ambilDataPerJam('19'); // Khusus hari Rabu
        if (dataJam19) {
            dataKirim.jam_19 = dataJam19;
        }

        let dataJam07 = ambilDataPerJam('07');
        if (dataJam07) {
            dataKirim.jam_07 = dataJam07;
        }

        // [C.2] TAMBAHAN: Ambil Data Jam Operasi (untuk tabel hours)
            dataKirim.jam_operasi = {
                turbine: ambilNilaiInput('jam_operasi_turbine'),
                synchro: ambilNilaiInput('jam_operasi_synchro'),
                pln:     ambilNilaiInput('jam_operasi_pln')
            };

            // [C.3] TAMBAHAN: Ambil Data Ringkasan (untuk tabel hasil)
            dataKirim.ringkasan = {
                avg_turbine: ambilNilaiTeks('hasil_avg_turbine'),
                avg_synchro: ambilNilaiTeks('hasil_avg_synchro'),
                avg_pln:     ambilNilaiTeks('hasil_avg_pln'),
                day_turbine: ambilNilaiTeks('hasil_day_turbine'),
                day_synchro: ambilNilaiTeks('hasil_day_synchro'),
                day_pln:     ambilNilaiTeks('hasil_day_pln'),
                month_turbine: ambilNilaiTeks('hasil_month_turbine'),
                month_synchro: ambilNilaiTeks('hasil_month_synchro'),
                month_pln:     ambilNilaiTeks('hasil_month_pln')
            };
        // Cek di console browser untuk memastikan data sudah benar sebelum dikirim
        console.log("Data yang akan dikirim:", dataKirim);

        // D. Kirim ke Server (Controller CodeIgniter)
        kirimKeServer(dataKirim);
    }

    // =======================================================
    // FUNGSI BANTU 1: MENGAMBIL DATA JAM TERTENTU
    // =======================================================
    // Fungsi ini membuat kita tidak perlu menulis kode berulang-ulang.
    // Cukup panggil ambilDataPerJam('15'), dia akan cari semua input berakhiran _15
    function ambilDataPerJam(kodeJam) {
        // Cek dulu, apakah input untuk jam ini ada di layar?
        let cekInput = document.querySelector('input[name="Turbine_' + kodeJam + '"]');

        // Jika tidak ada (misal jam 19 sedang disembunyikan), kembalikan null (kosong)
        if (!cekInput) return null;

        // Jika ada, ambil semua isinya dan jadikan satu paket (Object)
        return {
            kwh_synchro:   ambilNilaiInput('Synchro_' + kodeJam),
            kwh_turbine:   ambilNilaiInput('Turbine_' + kodeJam),
            kwh_pln:       ambilNilaiInput('PLN_' + kodeJam),
            hasil_turbine: ambilNilaiTeks('hasil_turbine_' + kodeJam), // Ambil dari <td> atau <span>
            hasil_pln:     ambilNilaiTeks('hasil_pln_' + kodeJam)      // Ambil dari <td> atau <span>
        };
    }

    // =======================================================
    // FUNGSI BANTU 2: MEMBERSIHKAN FORMAT ANGKA
    // =======================================================
    // Tugas: Mengubah "1.250,50" (Format Indo) menjadi 1250.50 (Format Database)
    function bersihkanAngka(nilai) {
        // Kalau nilainya kosong, strip (-), atau error, anggap 0
        if (!nilai || nilai === '-' || nilai === 'NaN') return 0;

        if (typeof nilai === 'string') {
            // Hapus titik ribuan (contoh: 1.000 menjadi 1000)
            let tanpaTitik = nilai.split('.').join('');
            // Ganti koma dengan titik desimal (contoh: 1000,5 menjadi 1000.5)
            let formatBenar = tanpaTitik.replace(',', '.');
            return parseFloat(formatBenar);
        }
        return nilai;
    }

    // =======================================================
    // FUNGSI BANTU 3: AMBIL NILAI DARI KOTAK INPUT
    // =======================================================
    function ambilNilaiInput(namaInput) {
        let elemen = document.querySelector('input[name="' + namaInput + '"]');
        // Jika elemen ada dan isinya tidak kosong, ambil nilainya sebagai angka
        if (elemen && elemen.value !== "") {
            return parseFloat(elemen.value);
        }
        return 0; // Default 0
    }

    // =======================================================
    // FUNGSI BANTU 4: AMBIL NILAI DARI TEKS HASIL HITUNGAN
    // =======================================================
    function ambilNilaiTeks(namaAtribut) {
        let elemen = document.querySelector('[data-hasil="' + namaAtribut + '"]');
        if (elemen) {
            // Karena teks hasil itu ada format rupiahnya (titik/koma), harus dibersihkan dulu
            return bersihkanAngka(elemen.textContent);
        }
        return 0;
    }

    // =======================================================
    // FUNGSI BANTU 5: KIRIM AJAX (FETCH)
    // =======================================================
    function kirimKeServer(dataPayload) {
        // Alamat tujuan di Controller
        const url = "<?= base_url('hitungan_turbine/simpan') ?>";

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(dataPayload) // Ubah data jadi text JSON
        })
        .then(response => response.json()) // Baca balasan server sebagai JSON
        .then(hasil => {
            if (hasil.status === true) {
                alert("Berhasil: " + hasil.message);
                location.reload(); // Refresh halaman agar data terbaru muncul
            } else {
                alert("Gagal: " + hasil.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Terjadi kesalahan sistem. Cek Console.");
        });
    }

});

</script>

