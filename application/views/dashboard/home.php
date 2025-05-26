   <!-- header -->
   <?php $this->load->view('dashboard/template/header') ?>
   <!-- end header -->

   <!-- Sidebar -->
   <?php $this->load->view('dashboard/template/sidebar') ?>
   <!-- End of Sidebar -->

   <!-- Content Wrapper -->
   <div id="content-wrapper" class="d-flex flex-column">

       <style>
           .highcharts-figure,
           .highcharts-data-table table {
               min-width: 310px;
               max-width: 900px;
               margin: 1em auto;
           }

           #container {
               height: 400px;
           }

           .highcharts-data-table table {
               font-family: Verdana, sans-serif;
               border-collapse: collapse;
               border: 1px solid #ebebeb;
               margin: 10px auto;
               text-align: center;
               width: 100%;
               max-width: 500px;
           }

           .highcharts-data-table caption {
               padding: 1em 0;
               font-size: 1.2em;
               color: #555;
           }

           .highcharts-data-table th {
               font-weight: 600;
               padding: 0.5em;
           }

           .highcharts-data-table td,
           .highcharts-data-table th,
           .highcharts-data-table caption {
               padding: 0.5em;
           }

           .highcharts-data-table thead tr,
           .highcharts-data-table tr:nth-child(even) {
               background: #f8f8f8;
           }

           .highcharts-data-table tr:hover {
               background: #f1f7ff;
           }
       </style>

       <!-- Main Content -->
       <div id="content">

           <!-- Topbar -->
           <?php $this->load->view('dashboard/template/topbar') ?>
           <!-- End of Topbar -->

           <!-- Begin Page Content -->
           <div class="container-fluid">

               <!-- Page Heading -->
               <div class="d-sm-flex align-items-center justify-content-between mb-4">
                   <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
               </div>

               <!-- Content Row -->
               <div class="row">

                   <!-- Area Chart -->
                   <div class="col-xl-12 col-lg-7">
                       <div class="card shadow mb-4">
                           <!-- Card Header - Dropdown -->
                           <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                               <h6 class="m-0 font-weight-bold text-primary"></h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                               <!-- <div class="chart-area">
                                   <canvas id="myAreaChart"></canvas>
                               </div> -->
                               <figure class="highcharts-figure">
                                   <div id="container"></div>
                                   <p class="highcharts-description">

                                   </p>
                               </figure>
                               <div class="card shadow mb-4">
                                   <div class="card-header py-3">
                                       <h6 class="m-0 font-weight-bold"><b>Buku Tandon Yang Sering Dipinjam</b></h6>
                                   </div>
                                   <div class="card-body">
                                       <div class="table-responsive">
                                           <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                               <div class="row">
                                                   <div class="col-sm-12">
                                                       <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                                           <thead>
                                                               <tr role="row">
                                                                   <td  rowspan="1" colspan="1" style="width: 12.2px;">No</td>
                                                                   <td  rowspan="1" colspan="1" style="width: 22.2px;">No.Barcode</td>
                                                                   <td  rowspan="1" colspan="1" style="width: 195.2px;">Judul</td>
                                                                   <td  rowspan="1" colspan="1" style="width: 19.2px;">Jumlah</td>
                                                               </tr>
                                                           </thead>
                                                           <tbody>
                                                            <?php $no=1; foreach ($most_viewed_book as $key => $value) { ?>
                                                                <tr class="even">
                                                                   <td><?php echo $no ?></td>
                                                                   <td><?php echo $value['barcode'] ?></td>
                                                                   <td><?php echo $value['judul'] ?></td>
                                                                   <td><?php echo $value['jumlah'] ?></td>
                                                               </tr>
                                                            <?php  $no++; } ?>
                                                           
                
                                                           </tbody>
                                                       </table>
                                                   </div>
                                               </div>
                                
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
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
           const month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Augustus", "September",
               "Oktober", "November", "Desember"
           ];

           $.ajax({
               type: "get",
               url: "<?php echo base_url() . INDEX_URL ?>dashboard/home/getStatistik",
               dataType: "json",
               success: function(response) {
                   // console.log(response);

                   if (response) {
                       var jumlah_koleksi = [];
                       var jumlah_pemustaka = [];
                       var bulTahun = [];
                       for (var i = 0; i < response.data.length; i++) {
                           //data untuk cart
                           jumlah_koleksi[i] = parseInt(response.data[i].jumlah_koleksi);
                           jumlah_pemustaka[i] = parseInt(response.data[i].jumlah_pemustaka);
                            bulTahun[i] =response.data[i].blnTahun ;
                           //end
                       }


                       var first_tglbulan_data=response.data[0].blnTahun;
                       var akhir_tglbulan_data=response.data[response.data.length-1].blnTahun;


                       Highcharts.chart('container', {
                           chart: {
                               type: 'column'
                           },
                           title: {
                               text: 'Statistik Jumlah Peminjaman Buku Tandon Dari '+first_tglbulan_data+' - '+akhir_tglbulan_data,
                               align: 'center'
                           },
                           subtitle: {
                               text: 'Data ditampilkan adalah 2 Tahun',
                               align: 'center'
                           },
                           xAxis: {
                               categories: bulTahun,
                               crosshair: true,
                               accessibility: {
                                   description: 'Tanggal'
                               }
                           },
                           yAxis: {
                               min: 0,
                               title: {
                                   text: 'Jumlah'
                               }
                           },
                           tooltip: {
                               valueSuffix: ''
                           },
                           plotOptions: {
                               column: {
                                   pointPadding: 0.2,
                                   borderWidth: 0
                               }
                           },
                           credits: {
                               enabled: false
                           },
                           series: [{
                                   name: 'Jumlah Pemustaka',
                                   data: jumlah_pemustaka
                               },
                               {
                                   name: 'Jumlah Koleksi',
                                   data: jumlah_koleksi
                               }
                           ]
                       });


                   }

               }
           });
       });
   </script>