<?php
$this->load->view('layouts/header', array("active" => 'test'));
?>

<body>
    <div class="container-fluid mt-4 mb-4">

        <center>
            <h3>Laporan Pemakaian</h3>
        </center>

        <div class="row">
            <div class="col-md-12">
                <div class="collapse mb-4 show" id="formDataAdd">
                    <div class="card">
                        <div class="card-header bg-success">
                            <span class="btn btn-success">Filter Data</span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" autocomplete="off" />
                            </div>
                            <button type="button" class="btn btn-success" onclick="Datatable()">Lihat Data</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="dataTable" style="overflow-x:auto;"></div>
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
        Datatable = () => {

            $.ajax({
                url: "<?php echo base_url('laporanController/data_pemakaian'); ?>",
                type: 'post',
                data: {
                    tanggal: $('#tanggal').val(),
                },
                dataType: 'json',
                success: function(response) {

                    //TODO ===== DataTable ======

                    let data = response.data;
                    let dataTable = `<table id="example" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5vw">#</th>
                                <th >PLAT&nbsp;KENDARAAN</th>
                                <th >MEREK&nbsp;KENDARAAN</th>
                                <th >TGL&nbsp;PAKAI</th>
                                <th >NAMA&nbsp;BARANG</th>
                                <th >NO&nbsp;IDENTITAS</th>
                                <th >KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    var no = 0;
                    for (let i = 0; i < data.length; i++) {
                        no++;
                        dataTable = dataTable + `<tr>
                                <th>${no}</th>
                                <td>${data[i].plat}</td>
                                <td>${data[i].merek}</td>
                                <td>${data[i].tanggal}</td>
                                <td>${data[i].barang}</td>
                                <td>${data[i].no_identitas}</td>
                                <td>${data[i].keterangan}</td>
                            </tr>`;
                    }


                    $('#dataTable').html(`${dataTable}</tbody></table>`);
                    $('#example').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });

                    //TODO ===== END DataTable ======
                }
            });
        }
    </script>

</body>

<?php
$this->load->view('layouts/footer');
?>