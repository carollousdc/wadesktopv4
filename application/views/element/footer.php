<footer class="main-footer">
  <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">SAPCoRP.io</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.0.4
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="asset/admin/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="asset/admin/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="asset/admin/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="asset/admin/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<!-- <script src="asset/admin/sparklines/sparkline.js"></script> -->
<!-- JQVMap -->
<script src="asset/admin/jqvmap/jquery.vmap.min.js"></script>
<script src="asset/admin/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="asset/admin/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="asset/admin/moment/moment.min.js"></script>
<script src="asset/admin/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="asset/admin/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="asset/admin/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="asset/admin/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- SAPCoRP App -->
<script src="asset/js/adminlte.js"></script>
<!-- SAPCoRP dashboard demo (This is only for demo purposes) -->
<!-- <script src="asset/js/pages/dashboard.js"></script> -->
<!-- SAPCoRP for demo purposes -->
<script src="asset/js/demo.js"></script>

<script src='asset/admin/datatables/jquery.dataTables.min.js'></script>
<script src='asset/admin/datatables-bs4/js/dataTables.bootstrap4.min.js'></script>
<script src='asset/admin/datatables-responsive/js/dataTables.responsive.min.js'></script>
<script src='asset/admin/datatables-responsive/js/responsive.bootstrap4.min.js'></script>
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": true,
      "info": true,
      "paging": true,
      "lengthChange": true,
      "ordering": true,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>

</html>
<?= $jsFile ?>