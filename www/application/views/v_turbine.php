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
?>
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          <div class="box-header">
          
          <h3 class='box-title'>
          Tanggal: <?= isset($energies->time) ? $nama_hari_indonesia . ', ' . $tanggal_indonesia : 'Data tidak tersedia'; ?>
      </h3>        </div>

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
              <!-- ID ENERGY UNTUK UPDATE -->
              <input type="hidden" id="id_energy" value="<?= $energies->id_energy ?>">
             <button type="button" id="simpan_turbine" class="btn btn-success"> Simpan </button>

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
          <!-- /.row -->
           <button type="button" class="btn btn-success">simpan</button>
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

