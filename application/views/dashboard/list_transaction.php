   <!-- header -->
   <?php $this->load->view('dashboard/template/header') ?>
   <!-- end header -->

   <!-- Sidebar -->
   <?php $this->load->view('dashboard/template/sidebar') ?>
   <!-- End of Sidebar -->

   <!-- Content Wrapper -->
   <div id="content-wrapper" class="d-flex flex-column">

       <!-- Main Content -->
       <div id="content">

           <!-- Topbar -->
           <?php $this->load->view('dashboard/template/topbar') ?>
           <!-- End of Topbar -->

           <!-- Begin Page Content -->
           <div class="container-fluid">

               <!-- Page Heading -->
               <h1 class="h3 mb-2 text-gray-800"><?php echo $page_title ?></h1>

               <!-- DataTales Example -->
               <div class="card shadow mb-4">
                   <div class="card-header py-3">
                       <h6 class="m-0 font-weight-bold text-primary"></h6>
                   </div>
                   <div class="card-body">
                       <div class="panel panel-default">
                           <div class="panel-body">
                               <div class="row">
                                   <div class="col-md-12">
                                       <div class="card card-primary">
                                           <div class="card-header">
                                               <h3 class="card-title">Pencarian</h3>
                                           </div>

                                           <div class="card-body">
                                               <form id="form-filter">
                                                   <div class="row">
                                                       <div class="col-md-6">

                                                           <div class="form-group">
                                                               <label>NIM</label>
                                                               <input type="text" class="form-control"
                                                                   placeholder="Input Nim" id="nim">
                                                           </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                           <!-- Date range -->
                                                           <div class="form-group">
                                                               <label>TANGGAL:</label>

                                                               <div class="input-group">
                                                                   <div class="input-group-prepend">
                                                                       <span class="input-group-text">
                                                                           <i class="far fa-calendar-alt"></i>
                                                                       </span>
                                                                   </div>
                                                                   <input type="text" class="form-control" id="tanggal"
                                                                       autocomplete="off" value="">
                                                               </div>
                                                               <!-- /.input group -->
                                                           </div>
                                                       </div>
                                                   </div>
                                               </form>
                                               <div class="card-footer">
                                                   <button type="button" id="btn-filter" class="btn btn-primary"><i
                                                           class="fas fa-search"></i>
                                                       Filter</button>
                                                   <button type="button" id="btn-reset"
                                                       class="btn btn-default">Reset</button>
                                                   <button type="button" id="btn-excel" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Execl</button>
                                               </div>

                                           </div>
                                       </div>

                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>



                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                               <thead>
                                   <tr>
                                       <th>NIM</th>
                                       <th>Barcode</th>
                                       <th>Judul</th>
                                       <th>Tgl Pinjam</th>
                                       <th>Tgl Kembali</th>
                                       <th>OP Pinjam</th>
                                       <th>OP Kembali</th>
                               </thead>

                               <tbody>

                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>

           </div>
           <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->

       <!-- Footer -->
       <?php $this->load->view('dashboard/template/footer_copyright') ?>
       <!-- End of Footer -->

   </div>
   <!-- End of Content Wrapper -->

   </div>
   <!-- End of Page Wrapper -->

   <!-- Footer -->
   <?php $this->load->view('dashboard/template/footer') ?>
   <!-- End of Footer -->

   <style>
       .redClass {
           background-color: red;
           color: white;
       }
   </style>

   <script type="text/javascript">
       // Call the dataTables jQuery plugin
       $(document).ready(function() {
           var table;
           table = $('#table').DataTable({
               "processing": true, //Feature control the processing indicator.
               "serverSide": true, //Feature control DataTables' server-side processing mode.
               "order": [], //Initial no order.
               "ajax": {
                   "url": "<?php echo base_url() . INDEX_URL ?>/dashboard/list_transaction/ajax_list",
                   'data': function(data) {
                       data.searchNim = $('#nim').val();
                       data.searchTanggal = $('#tanggal').val();
                   },
                   "type": "POST"
               },
               "createdRow": function(row, data, dataIndex) {
                   if (data[3] == 'Belum Dikembalikan') {
                       $(row).addClass('redClass');
                   }
               }
           });

           $('#btn-filter').click(function() { //button filter event click
               table.ajax.reload(); //just reload table
           });

           $('#btn-reset').click(function() { //button reset event click
               $('#form-filter')[0].reset();
               table.ajax.reload(); //just reload table
           });


           $('#btn-excel').click(function() { //button reset event click
               if ($('#tanggal').val() == '') {
                   alert('Tanggal Harus Diisi');
                   return false;
               }
               var tanggal = $("#tanggal").val();
               location.href = "<?= base_url() . INDEX_URL ?>dashboard/list_transaction/export_excel?tanggal=" + tanggal;
           });

       });
       //Date range picker
       $('#tanggal').daterangepicker({
           autoUpdateInput: false,
           locale: {
               cancelLabel: 'Clear'
           }
       });

       $('#tanggal').on('apply.daterangepicker', function(ev, picker) {
           $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
       });
   </script>