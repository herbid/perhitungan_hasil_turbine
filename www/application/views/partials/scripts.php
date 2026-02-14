<!-- jQuery 3 -->
 
<script src="<?=base_url('assets/')?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('assets/')?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?=base_url('assets/')?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/')?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?=base_url('assets/')?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url('assets/')?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets/')?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url('assets/')?>dist/js/demo.js"></script>
<!-- date-range-picker -->
<script src="<?=base_url('assets/')?>bower_components/moment/min/moment.min.js"></script>

<!-- ChartJS -->
<script src="<?=base_url('assets/')?>bower_components/chart.js/Chart.js"></script>
<!-- Select2 -->
<script src="<?=base_url('assets/')?>bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url('assets/')?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=base_url('assets/')?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=base_url('assets/')?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="<?=base_url('assets/')?>bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url('assets/')?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?=base_url('assets/')?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="<?=base_url('assets/')?>bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?=base_url('assets/')?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="<?=base_url('assets/')?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?=base_url('assets/')?>plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url('assets/')?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets/')?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url('assets/')?>dist/js/demo.js"></script>
<script src="<?=base_url('assets/')?>bower_components/Flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?=base_url('assets/')?>bower_components/Flot/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?=base_url('assets/')?>bower_components/Flot/jquery.flot.pie.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="<?=base_url('assets/')?>bower_components/Flot/jquery.flot.categories.js"></script>


<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();
    
    // Initialize Push Menu
    $('[data-toggle="push-menu"]').pushMenu({
      collapseScreenSize: 767,
      expandOnHover: false,
      expandTransitionDelay: 200
    });
    
    // Direct click handler for sidebar toggle
    $(document).on('click', '[data-toggle="push-menu"]', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var isOpen = $('body').hasClass('sidebar-open');
      if (isOpen) {
        $('body').removeClass('sidebar-open').addClass('sidebar-collapse');
      } else {
        $('body').removeClass('sidebar-collapse').addClass('sidebar-open');
      }
    });
  })
</script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable({
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": 0,
                "type": "date",
                "orderData": 0
            }
        ]
    });
    
    $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "order": [[0, "desc"]] // Urutkan berdasarkan kolom pertama secara descending
    });


//Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'MM/DD/YYYY hh:mm A' }})
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
     //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      endDate: new Date(),
      format: 'dd/mm/yyyy'
    }).on('changeDate', function(e) {
      var selectedDate = $(this).val();
      if (selectedDate) {
        console.log('Tanggal Dipilih: ' + selectedDate);
      }
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck  
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })

  
</script>

<script>
  $(function () {
   /*
     * LINE CHART
     * ----------
     */
    
    // Ambil data line chart dari PHP (day_pln)
    var lineChartDataJSON = <?php echo isset($line_chart_data) ? $line_chart_data : '[]'; ?>;
    
    // Persiapan data untuk line chart
    var line_data = {
      data : lineChartDataJSON.length > 0 ? lineChartDataJSON : [],
      color: '#00c0ef',
      label: 'Export PLN (kWh)'
    }
    
    $.plot('#line-chart', [line_data], {
      grid  : {
        hoverable  : true,
        borderColor: '#f3f3f3',
        borderWidth: 1,
        tickColor  : '#f3f3f3'
      },
      series: {
        shadowSize: 0,
        lines     : {
          show: true
        },
        points    : {
          show: true
        }
      },
      lines : {
        fill : false,
        color: '#00c0ef'
      },
      yaxis : {
        show: true
      },
      xaxis : {
        mode      : 'categories',
        show: true
      }
    })
    
    // Tampilkan tooltip dengan nilai ketika hover di line chart
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8,
      backgroundColor: '#000',
      color: '#fff',
      padding: '5px 10px',
      borderRadius: '3px',
      fontSize: '12px'
    }).appendTo('body')
    
    $('#line-chart').bind('plothover', function (event, pos, item) {
      if (item) {
        var nilaiKWh = item.datapoint[1].toFixed(2);
        $('#line-chart-tooltip').html(nilaiKWh + ' kWh')
          .css({ top: item.pageY - 40, left: item.pageX + 5 })
          .fadeIn(200)
      } else {
        $('#line-chart-tooltip').hide()
      }
    })
    /* END LINE CHART */
  
  /*
     * BAR CHART
     * ---------
     */

    // Get chart data from PHP variable
    // Format data: [['Tanggal', nilai_production], ...]
    var chartDataJSON = <?php echo isset($chart_data) ? $chart_data : '[]'; ?>;
    
    // Inisialisasi bar chart dengan data dari database
    var bar_data;
    if (chartDataJSON && chartDataJSON.length > 0) {
      // Menggunakan data actual dari database (day_turbine dengan tanggal)
      bar_data = {
        data : chartDataJSON,
        color: '#3c8dbc'
      };
    } else {
      // Tidak ada data dari database - tampilkan chart kosong
      bar_data = {
        data : [],
        color: '#3c8dbc'
      };
    }
    
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3',
        hoverable  : true
      },
      series: {
        bars: {
          show    : true,
          barWidth: 0.5,
          align   : 'center'
        }
      },
      xaxis : {
        mode      : 'categories',
        tickLength: 0
      }
    })
    
    // Tampilkan tooltip dengan nilai ketika hover di bar chart
    $('<div class="tooltip-inner" id="bar-chart-tooltip"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8,
      backgroundColor: '#000',
      color: '#fff',
      padding: '5px 10px',
      borderRadius: '3px',
      fontSize: '12px'
    }).appendTo('body')
    
    $('#bar-chart').bind('plothover', function (event, pos, item) {
      if (item) {
        var nilaiKWh = item.datapoint[1].toFixed(2);
        $('#bar-chart-tooltip').html(nilaiKWh + ' kWh')
          .css({ top: item.pageY - 40, left: item.pageX + 5 })
          .fadeIn(200)
      } else {
        $('#bar-chart-tooltip').hide()
      }
    })
    /* END BAR CHART */


  })

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
  
</script>

  