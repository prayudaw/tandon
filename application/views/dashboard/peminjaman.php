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
                                   <!-- Form Group (NIM)-->
                                   <div class="col-md-5">
                                       <div class="row">
                                           <div class="col control-label">
                                               <label for="nimPinjam" class="nimPinjam" id="nimPinjam"
                                                   style="font-size: 18px;">NIM</label>
                                           </div>
                                           <div class="col control-label">
                                               <input class="form-check-input" type="checkbox" value="" id="checkTamu">
                                               <label class="form-check-label" for="checkTamu">
                                                   Tamu
                                               </label>
                                           </div>
                                       </div>
                                       <div>
                                           <input class="form-control" id="inputNim" type="text"
                                               placeholder="Masukan NIM" value="" fdprocessedid="0z00uc">
                                       </div>
                                       <!-- <label class="small mb-1" for="inputNim">NIM</label>               
                                            <input class="form-control" id="inputNim" type="text" placeholder="Masukan NIM" value="" fdprocessedid="0z00uc"> -->
                                   </div>
                                   <!-- Form Group (Barcode)-->
                                   <div class="col-md-5">
                                       <label class="small mb-1" for="inputBarcode"
                                           style="font-size: 18px;">Barcode</label>
                                       <input class="form-control" id="inputBarcode" type="text"
                                           placeholder="Masukan Barcode" value="" fdprocessedid="djg99d"
                                           style="font-size:18px;">
                                   </div>
                                   <div class="col-md-2">
                                       <!-- Save changes button-->
                                       <input type="submit" value="Pinjam"
                                           style="font-size: 20px !important; height:53px!important;padding: 15px 0;position: absolute;bottom: -8px;"
                                           class="btn btn-success mb-2 w-100 btnPinjam" fdprocessedid="f81maf">
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
    $('#inputNim').focus();

    $("#checkTamu").click(function() {
        $('#inputNim').focus();
        var text = $("#nimPinjam").text();
        if (text == 'NIM') {
            $("#nimPinjam").text('Nama Tamu');
            $("#inputNim").attr('placeholder', 'Masukkan Nama Tamu');
            $("#inputNim").val('');

        } else {
            $("#nimPinjam").text('NIM');
            $("#inputNim").attr('placeholder', 'Masukkan NIM');
            $("#inputNim").val('');
        }
    });

    $('#inputNim').keypress((e) => {
        // Enter key corresponds to number 13
        if (e.which === 13) {
            e.preventDefault();
            var inputNim = $('#inputNim').val();
            if (inputNim != '') {
                $('#inputBarcode').focus();
            }
        }
    });

    $('#tamu').click((e) => {
        // Enter key corresponds to number 13
        e.preventDefault();
        var inputNim = $('#tamu').val();
        if (inputNim != '') {
            $('#tamu').focus();
        }

    });

    $(".btnPinjam").click(function(e) {
        e.preventDefault();

        var textLabel = $("#nimPinjam").text();
        var tamu = false;
        var nim = $("#inputNim").val();
     
        var barcode = $("#inputBarcode").val();

        if (nim.length == "") {
            var message = '';
            if (textLabel == 'NIM') {
                message = 'NIM e Harus Diisi!';
            } else {
                message = 'Nama Tamu Harus Diisi!';
            }

            $('.alert-danger').show().html(message)
            setTimeout(function() {
                $('.alert-danger').html('');
                $('.alert-danger').hide();
            }, 2000);
            $('#inputNim').focus();
        } else if (barcode.length == "") {
            $('.alert-danger').show().html('Barcode Wajib Diisi!')
            setTimeout(function() {
                $('.alert-danger').html('');
                $('.alert-danger').hide();
            }, 2000);
            $('#inputBarcode').focus();
        } else {
               if (textLabel == 'Nama Tamu') {
                    nim = 'TM-' + nim;
                    tamu = true;
                }
              $.ajax({
                type: "POST",
                url: "<?php echo base_url().INDEX_URL ?>dashboard/peminjaman/inputPeminjam",
                data: {
                    "nim": nim,
                    "barcode": barcode,
                    "tamu": tamu
                },
                success: function(response) {
                    console.log(response);
                    // return false;
                    response = JSON.parse(response);
                    if (response.status == 1) {
                        $('.alert-success').show().html(response.message)
                        setTimeout(function() {
                            $('.alert-success').html('');
                            $('.alert-success').hide();
                        }, 2000);
                        $('#inputNim').focus();
                        $("#nimPinjam").text('NIM');
                        $("#inputNim").attr('placeholder', 'Masukkan NIM');
                        $("#inputNim").val('');
                        $("#inputBarcode").val('');
                        // similar behavior as clicking on a link                          
                    } else {
                        $('.alert-danger').show().html(response.message)
                        setTimeout(function() {
                            $('.alert-danger').html('');
                            $('.alert-danger').hide();
                        }, 2000);
                        $('#inputNim').focus();
                        $("#inputBarcode").val('');



                    }

                }
            });

        }

    });

});
   </script>