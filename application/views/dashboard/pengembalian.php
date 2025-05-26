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

               <div class="row">

                   <div class="card-body">
                       <div class="col-xl-12">
                           <div class="alert alert-danger" role="alert" style="display:none">
                           </div>
                           <div class="alert alert-success" role="alert" style="display:none">
                           </div>
                           <form>
                               <!-- Form Row-->
                               <div class="row gx-3 mb-3">
                                   <!-- Form Group (Barcode)-->
                                   <div class="col-md-5">
                                       <label class="small mb-1" for="inputBarcode"
                                           style="font-size:18px">Barcode</label>
                                       <input class="form-control" id="inputBarcode" type="text"
                                           placeholder="Masukan Barcode" value="" fdprocessedid="djg99d">
                                   </div>
                                   <div class="col-md-2">
                                       <!-- Save changes button-->
                                       <input type="submit" value="kembali"
                                           style="font-size: 20px !important; height:53px!important;padding: 15px 0;position: absolute;bottom: -8px;"
                                           class="btn btn-success mb-2 w-100 btnKembali" fdprocessedid="f81maf">
                                   </div>
                               </div>
                           </form>
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
    $('#inputBarcode').focus();

    $(".btnKembali").click(function(e) {
        e.preventDefault();
        var barcode = $("#inputBarcode").val();

        if (barcode.length == "") {
            $('.alert-danger').show().html('Barcode Wajib Diisi!')
            setTimeout(function() {
                $('.alert-danger').html('');
                $('.alert-danger').hide();
            }, 2000);
            $('#inputBarcode').focus();
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().INDEX_URL ?>dashboard/pengembalian/proses_kembali",
                data: {
                    "barcode": barcode
                },
                success: function(response) {
                    console.log(response);
                    //return false;
                    response = JSON.parse(response);
                    if (response.status == 1) {
                        $('.alert-success').show().html(response.message)
                        setTimeout(function() {
                            $('.alert-success').html('');
                            $('.alert-success').hide();
                        }, 2000);
                        $('#inputBarcode').focus();
                        $("#inputBarcode").val('');
                        // similar behavior as clicking on a link                          
                    } else {
                        $('.alert-danger').show().html(response.message)
                        setTimeout(function() {
                            $('.alert-danger').html('');
                            $('.alert-danger').hide();
                            $('#inputBarcode').focus();
                            $("#inputBarcode").val('');
                        }, 2000);




                    }

                }
            });

        }

    });

});
   </script>