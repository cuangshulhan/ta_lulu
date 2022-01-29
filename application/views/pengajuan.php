<?php
$this->load->view('layouts/header', array("active" => 'test'));
?>

<body>
    <?php
    if (!validation_errors())
        if ($status == 201)
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>' . str_replace("_", " ", $message) . '</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        elseif ($status == 400)
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>' . str_replace("_", " ", $message)  . '</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';

    if (validation_errors()) {
        if ($valid_error == 'insert') {
            $show = 'show';
            $show_edit = '';
        } elseif ($valid_error == 'update') {
            $show_edit = 'show';
            $show = '';
        }
    } else {
        $show = '';
        $show_edit = '';
    }

    ?>
    <div class="container-fluid mt-4 mb-4">

        <center>
            <h3>Transaksi Pengajuan</h3>
        </center>
        <!-- TODO ================== Form Detail Data ==========================-->

        <div class=" row">
            <div class="col">
                <div class="collapse mb-4" id="formDataDetail">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <span class="btn btn-secondary">Detail Data Pemesanan</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;" onclick="closeDetail()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Kode Pemesanan</label>
                                        <input type="text" class="form-control" name="kode_pesan_detail" id="kode_pesan_detail" autocomplete="off" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Toko</label>
                                        <?php echo form_error('toko_detail', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                        <select class="form-control" name="toko_detail" id="toko_detail" disabled>
                                            <?php foreach ($satuan['data'] as $row) : ?>
                                                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_detail" id="tanggal_detail" autocomplete="off" disabled />
                                    </div>
                                    <div class="form-group">
                                        <label>Pimpinan Terkait</label>
                                        <input type="text" class="form-control" name="pimpinan_detail" id="pimpinan_detail" autocomplete="off" readonly />
                                    </div>
                                    <button type="button" id="simpan_detail" class="btn btn-secondary mb-2" onclick="ProsesData()">Proses Data</button>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status_detail" id="status_detail">
                                                <option value="Menunggu">Menunggu</option>
                                                <option value="Diterima">Diterima</option>
                                                <option value="Ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Catatan Pimpinan</label>
                                        <textarea class="form-control" name="catatan_detail" id="catatan_detail" rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea class="form-control" name="keterangan_detail" id="keterangan_detail" rows="2" disabled></textarea>
                                    </div>
                                </div>

                                <div class="col-md-7 card bg-secondary">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex">
                                                <div class="mr-auto p-2">
                                                    <select class="form-control" style="width: 80px;" onchange="btnLimitDetail(this.value)">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                                <div class="p-2">
                                                    <input type="text" class="form-control" id="pencarian_detail" placeholder="Pencarian" onkeyup="pencarianDetail(this.value)" />
                                                </div>
                                            </div>
                                            <div id="dataTableDetail" style="height: 49vh;overflow-x:auto;overflow-y:auto;"></div>
                                            <div class="d-flex">
                                                <div class="ml-auto p-2">
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination" id="pagination_detail"> </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                            <div id="recordTotalDetail" class="mb-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- TODO ================== DATA ON TABLE ==========================-->

        <div class="row">
            <div class="col">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <select class="form-control" style="width: 80px;" onchange="btnLimit(this.value)">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="p-2">
                        <select class="form-control" style="width: 110px;" onchange="btnSearchBy(this.value)">
                            <option value="kode_pesan">KODE PESAN</option>
                        </select>
                    </div>
                    <div class="p-2">
                        <input type="text" class="form-control" id="pencarian" placeholder="Pencarian" onkeyup="pencarian(this.value)" />
                    </div>
                </div>
                <div id="dataTable" style="overflow-x:auto;"></div>
                <div class="d-flex">
                <div class="p-2">
                        <select class="form-control" style="width: 100%;" onchange="btnSortstatus(this.value)">
                            <option value="all">Semua</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="ml-auto p-2">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination"> </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var limit = 5;
        var page = 1;
        var sort_by = 'desc';
        var order_by = 'id';
        var keyword = '';
        var search_by = 'kode_pesan';
        var sort_by_status = 'all';

        $(document).ready(function() {
            Datatable();
        });

        btnPagination = (selected) => {
            page = selected;
            Datatable();
        }

        btnLimit = (selected) => {
            limit = selected;
            Datatable();
        }

        btnSearchBy = (selected) => {
            search_by = selected;
            Datatable();
        }

        pencarian = (param) => {
            keyword = param;
            Datatable();
        }

        btnSortstatus = (param) => {
            sort_by_status = param;
            Datatable();
        }

        Datatable = () => {

            $.ajax({
                url: "<?php echo base_url('pengajuanController/datatable'); ?>",
                type: 'post',
                data: {
                    limit: limit,
                    page: page,
                    order_by: order_by,
                    sort_by: sort_by,
                    keyword: keyword,
                    search_by: search_by,
                    sort_by_status: sort_by_status
                },
                dataType: 'json',
                success: function(response) {

                    //TODO ===== DataTable ======

                    let data = response.data;
                    let dataTable = `<table class="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="60vw">#</th>
                                <th scope="col">KODE&nbsp;PESAN</th>
                                <th scope="col">TANGGAL&nbsp;DIAJUKAN</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">KETERANGAN</th>
                                <th scope="col" width="150vw" class="text-center">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (response.recordsTotal == 0) {
                        dataTable = dataTable + `<td colspan="5" class="text-center">Data tidak ditemukan</td>`;

                    } else {
                        var no = response.offset;
                        for (let i = 0; i < data.length; i++) {
                            no++;
                            var btn_status = data[i].status == 'Menunggu' ? 'btn-info' : data[i].status == 'Diterima' ? 'btn-success' : 'btn-danger';

                            dataTable = dataTable + `<tr>
                                <th scope="row">${no}</th>
                                <td>${data[i].kode_pesan}</td>
                                <td>${data[i].tanggal}</td>
                                <td><button class="btn btn-sm ${btn_status}" >${data[i].status}</button></td>
                                <td><textarea cols="50" rows="1">${data[i].keterangan}</textarea></td>
                                <td class="text-center">

                                    <button type="button" class="btn btn-outline-secondary btn-sm" aria-pressed="true" title="Detail Data" data-toggle="collapse" aria-expanded="false" onclick="btnDetail('${data[i].kode_pesan}')"><i class="far fa-folder-open"></i></button>
                                    
                                </td> 
                            </tr>`;
                        }
                    }

                    $('#dataTable').html(`${dataTable}</tbody></table>`);

                    //TODO ===== END DataTable ======

                    //TODO ===== Pagination ======

                    let pagination = Math.ceil(response.recordsTotal / limit);
                    var dataPaging = `<li class="page-item"><a class="page-link" onclick="btnPagination(${page - 1})">Previous</a></li>`;

                    for (let i = 1; i <= pagination; i++) {
                        dataPaging = dataPaging + `<li class="page-item"><a class="page-link ${page == i ? 'bg-primary' : '' }" onclick="btnPagination(${i})" style=color:${page == i ? 'white' : 'black' };>${i}</a></li>`
                    }

                    dataPaging = dataPaging + `<li class="page-item"><a class="page-link" onclick="btnPagination(${page + 1})">Next</a></li>`;

                    $('.pagination').html(dataPaging)

                    //TODO ===== END Pagination ======
                }
            });
        }

        var id_detail = '';
        var limit_detail = 5;
        var page_detail = 1;
        var sort_by_detail = 'desc';
        var order_by_detail = 'id';
        var keyword_detail = '';
        var search_by_detail = 'barang';

        btnDetail = (id) => {

            id_detail = id;
            DatatableDetail();
            DetailHeader(id);

            $('#formDataDetail').hide(100);
            $('#formDataDetail').show(500);
        }

        closeDetail = () => {

            $('#formDataDetail').hide(500);
        }

        btnPaginationDetail = (selected) => {
            page_detail = selected;
            DatatableDetail();
        }

        btnLimitDetail = (selected) => {
            limit_detail = selected;
            DatatableDetail();
        }

        btnSearchByDetail = (selected) => {
            search_by_detail = selected;
            DatatableDetail();
        }

        pencarianDetail = (param) => {
            keyword_detail = param;
            DatatableDetail();
        }

        DetailHeader = (kode_pesan) => {

            $.ajax({
                url: "<?php echo base_url('pengajuanController/detailHeader'); ?>",
                type: 'post',
                data: {
                    kode_pesan: kode_pesan,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        $('#kode_pesan_detail').val(response.data['kode_pesan']);
                        $('#toko_detail').val(response.data['id_toko']).change();
                        $('#tanggal_detail').val(response.data['tanggal']);
                        $('#status_detail').val(response.data['status']);
                        $('#pimpinan_detail').val(response.data['fullname']);
                        $('#catatan_detail').val(response.data['catatan_pemimpin']);
                        $('#keterangan_detail').val(response.data['keterangan']);

                        if(response.data['status'] != 'Menunggu')
                            document.getElementById("simpan_detail").disabled = true;
                    }
                }
            });
        }

        DatatableDetail = () => {

            $.ajax({
                url: "<?php echo base_url('pengajuanController/datatableDetail'); ?>",
                type: 'post',
                data: {
                    id: id_detail,
                    limit: limit_detail,
                    page: page_detail,
                    order_by: order_by_detail,
                    sort_by: sort_by_detail,
                    keyword: keyword_detail,
                    search_by: search_by_detail,
                },
                dataType: 'json',
                success: function(response) {

                    //TODO ===== DataTable ======

                    let data = response.data;
                    let dataTable = `<table class="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="60vw">#</th>
                                <th>NO.&nbsp;NAMA&nbsp;BARANG</th>
                                <th>SATUAN</th>
                                <th>JUMLAH</th>
                                <th>HARGA</th>
                                <th>TOTAL</th>
                                <th>KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody class="bg-light">`;
                    if (response.recordsTotal == 0) {
                        dataTable = dataTable + `<td colspan="8" class="text-center">Data tidak ditemukan</td>`;

                    } else {
                        var no = response.offset;
                        for (let i = 0; i < data.length; i++) {
                            no++;
                            var disableButton = data[i].tgl_keluar != null ? 'disabled' : ''
                            dataTable = dataTable + `<tr>
                            <th scope="row">${no}</th>
                            <td>${data[i].barang}</td>
                            <td>${data[i].satuan}</td>
                            <td>${data[i].jumlah}</td>
                            <td>Rp.&nbsp;${FormatToRupiah(data[i].harga)}</td>
                            <td>Rp.&nbsp;${FormatToRupiah(data[i].total)}</td>
                            <td><textarea cols="30" rows="1">${data[i].keterangan}</textarea></td>
                        </tr>`;
                        }
                    }

                    $('#dataTableDetail').html(`${dataTable}</tbody></table>`);
                    $('#recordTotalDetail').html(`<div class="text-white">The results of the data : ${response.recordsTotal}</div>`);

                    //TODO ===== END DataTable ======

                    //TODO ===== Pagination ======

                    let pagination = Math.ceil(response.recordsTotal / limit);
                    var dataPaging = `<li class="page-item"><a class="page-link" onclick="btnPaginationDetail(${page_detail - 1})">Previous</a></li>`;

                    for (let i = 1; i <= pagination; i++) {
                        dataPaging = dataPaging + `<li class="page-item"><a class="page-link ${page_detail == i ? 'bg-primary' : '' }" onclick="btnPaginationDetail(${i})" style=color:${page_detail == i ? 'white' : 'black' };>${i}</a></li>`
                    }

                    dataPaging = dataPaging + `<li class="page-item" ><a class="page-link" onclick="btnPaginationDetail(${page_detail + 1})">Next</a></li>`;

                    $('#pagination_detail').html(dataPaging)

                    //TODO ===== END Pagination ======
                }
            });
        }

        FormatToRupiah = (bilangan) => {
	
            var	number_string = bilangan.toString(),
                split	= number_string.split(','),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                    
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            return rupiah;
        }

        ProsesData = () => {

            if ($('#status_detail').val() == 'Menunggu') {
                alert('Status proses belum ditentukan, diterima/ditolak');
                return false;
            }

            let text = "Apakah anda yakin?";
            if (confirm(text) == true) {

                $.ajax({
                    url: "<?php echo base_url('pengajuanController/prosesData'); ?>",
                    type: 'post',
                    data: {
                        kode_pesan: id_detail,
                        status: $('#status_detail').val(),
                        catatan: $('#catatan_detail').val(),
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message)
                            Datatable();
                        } else
                            alert(response.message)
                    }
                });
            } else
                return false;
        }
    </script>

</body>

<?php
$this->load->view('layouts/footer');
?>