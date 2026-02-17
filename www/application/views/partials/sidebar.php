<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url('assets/')?>icon/1-93_icon-icons.com_65658.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Operator Turbine</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <?php $uri = $this->uri->segment(1); ?>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" >
        <li class="header">MAIN NAVIGATION</li>

        <li class="<?= ($uri == '' || $uri == 'home') ? 'active' : '' ?>">
        <a href="<?= base_url('home') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>

    <li class="<?= ($uri == 'hitungan_turbine') ? 'active' : '' ?>">
        <a href="<?= base_url('hitungan_turbine') ?>">
            <i class="fa fa-calculator"></i> <span>Hitung Turbine</span>
        </a>
    </li>
      
         <li><a href="#" data-toggle="modal" data-target="#modal-logout">
          <i class="fa fa-close"></i> <span>Keluar</span>
          <span class="pull-right-container"></span>
        </a>
      </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <div class="modal fade" id="modal-logout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Konfirmasi Keluar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h1>Apakah Anda yakin ingin keluar dari aplikasi?</h1>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="<?=base_url('auth/logout_user')?>" class="btn btn-danger">Keluar</a>
      </div>
    </div>
    </div>
  </div>