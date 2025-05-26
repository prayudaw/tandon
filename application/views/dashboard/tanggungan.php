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
               <div class="d-sm-flex align-items-center justify-content-between mb-4">
                   <h1 class="h3 mb-0 text-gray-800"><?php echo $page_title ?></h1>

               </div>
               <p class="mb-4" style="font-size:20px;font-weight: bold;">Menampilkan daftar buku tandon kemarin-kemarin
                   yang belum dikembalikan
               </p>
               <!-- DataTales Example -->
               <div class="card shadow mb-4">
                   <div class="card-header py-3">
                       <h4 class="m-0 font-weight-bold text-primary">
                           <b><?php echo $jumlahTanggungan ?></b> Buku Belum dikembalikan
                       </h4>
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
                                       <th>OP Pinjam</th>
                               </thead>
                               <tbody>
                                   <?php  foreach ($getTanggungan as $v) { ?>
                                   <tr>
                                       <td><?php echo $v['nim'] ?></td>
                                       <td><?php echo $v['barcode'] ?></td>
                                       <td><?php echo $v['judul'] ?></td>
                                       <td><?php echo $v['tgl_pinjam'] ?></td>
                                       <td><?php echo $v['op_pinjam'] ?></td>
                                   </tr>
                                   <?php }?>

                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
           <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->

       <!-- Footer copyright -->
       <?php $this->load->view('dashboard/template/footer_copyright') ?>
       <!-- End of Footer copyright -->

   </div>
   <!-- End of Content Wrapper -->

   </div>
   <!-- End of Page Wrapper -->

   <!-- Sidebar -->
   <?php $this->load->view('dashboard/template/footer') ?>
   <!-- End of Sidebar -->
   <script type="text/javascript">
$(document).ready(function() {

    table = $('#table').DataTable({
        "paging": false, //Feature control the processing indicator.
        "serverSide": false, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "searching": false

    });


});
   </script>