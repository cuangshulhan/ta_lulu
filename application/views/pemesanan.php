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
            <h3>Transaksi Pemesanan</h3>
        </center>
        <!-- TODO ================== Form Tambah Data ==========================-->

        <div class=" row">
            <div class="col">
                <p>
                    <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#formDataAdd" aria-expanded="false" aria-controls="formDataAdd">
                        <i class="far fa-plus-square"></i> Tambah Data
                    </button>
                </p>
                <div class="collapse mb-4 <?= $show ?>" id="formDataAdd">
                    <div class="card">
                        <div class="card-header bg-success">
                            <span class="btn btn-success">Tambahkan data Pemesanan Header</span>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('pemesananController/insert'); ?>
                            <table width="100%">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label>Kode Pemesanan</label>
                                            <?php echo form_error('kode_pesan', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                            <input type="text" class="form-control" name="kode_pesan" id="kode_pesan" value="<?php echo set_value('kode_pesan'); ?>" autocomplete="off" readonly />
                                        </div>
                                    </td>
                                    <td>
                                        &nbsp;
                                        <button type="button" class="btn btn-success" style="margin-top: 15px;" onclick="getNoIdentitas()">....</button>
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <?php echo form_error('toko', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select class="form-control" name="toko" id="toko">
                                    <?php foreach ($satuan['data'] as $row) : ?>
                                        <?php
                                            $selected = set_value('toko') ==  $row->id ? 'selected="selected"' : '';
                                            ?>
                                        <option <?= $selected ?> value="<?= $row->id ?>"><?= $row->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <?php echo form_error('tanggal', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo set_value('tanggal'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <?php echo form_error('keterangan', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="2"><?php echo set_value('keterangan'); ?></textarea>

                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TODO ================== Form Edit Data ==========================-->

        <div class=" row">
            <div class="col">
                <div class="collapse mb-4 <?= $show_edit ?>" id="formDataEdit">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <span class="btn btn-primary">Edit data Pemesanan</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;" onclick="closeEdit()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('pemesananController/update'); ?>
                            <!-- <input type="hidden" class="form-control" name="id" id="id" value="<?php echo set_value('id'); ?>" /> -->
                            <div class="form-group">
                                <label>Kode Pemesanan</label>
                                <?php echo form_error('kode_pesan_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="kode_pesan_edit" id="kode_pesan_edit" value="<?php echo set_value('kode_pesan_edit'); ?>" autocomplete="off" readonly />
                            </div>
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <?php echo form_error('toko_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select class="form-control" name="toko_edit" id="toko_edit">
                                    <?php foreach ($satuan['data'] as $row) : ?>
                                        <?php
                                            $selected = set_value('toko_edit') ==  $row->id ? 'selected="selected"' : '';
                                            ?>
                                        <option <?= $selected ?> value="<?= $row->id ?>"><?= $row->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <?php echo form_error('tanggal_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="date" class="form-control" name="tanggal_edit" id="tanggal_edit" value="<?php echo set_value('tanggal_edit'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <?php echo form_error('keterangan_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <textarea class="form-control" name="keterangan_edit" id="keterangan_edit" rows="2"><?php echo set_value('keterangan_edit'); ?></textarea>

                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                    <button type="button" id="simpan_detail" class="btn btn-secondary mb-2" onclick="insertDetail()">Simpan Detail</button>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" name="status_detail" id="status_detail" autocomplete="off" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Catatan Pemimpin</label>
                                        <textarea class="form-control" name="catatan_detail" id="catatan_detail" rows="2" disabled></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea class="form-control" name="keterangan_detail" id="keterangan_detail" rows="2" disabled></textarea>
                                    </div>
                                </div>

                                <div class="col-md-7 card bg-secondary">
                                    <div class="row card-body text-white">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Barang | Satuan</label>
                                                <select class="form-control" name="barang_detail" id="barang_detail"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="number" class="form-control" name="jumlah_detail" id="jumlah_detail" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <input type="number" class="form-control" name="harga_detail" id="harga_detail" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <input type="text" class="form-control" name="ket_detail" id="ket_detail" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
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

        <!-- TODO ================== Form Pengajuan ==========================-->

        <div class=" row">
            <div class="col">
                <div class="collapse mb-4" id="formPengajuan">
                    <div class="card">
                        <div class="card-header bg-info">
                            <span class="btn btn-info">Form Pengajuan</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;" onclick="closeSubmission()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <input type="hidden" class="form-control" name="id_header_pesanan" id="id_header_pesanan" />
                            <div class="form-group">
                                <label>Pimpinan Terkait</label>
                                <select class="form-control" name="pimpinan_terkait" id="pimpinan_terkait">
                                    <?php foreach ($pimpinan['data'] as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->fullname ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <button type="button" class="btn btn-info" onclick="btnAjukanPesanan()">Ajukan Pemesanan</button>
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
                            <option value="nama">NAMA TOKO</option>
                        </select>
                    </div>
                    <div class="p-2">
                        <input type="text" class="form-control" id="pencarian" placeholder="Pencarian" onkeyup="pencarian(this.value)" />
                    </div>
                </div>
                <div id="dataTable" style="height: 49vh;overflow-x:auto;overflow-y:auto;"></div>
                <div class="d-flex">
                    <div class="p-2">
                        <select class="form-control" style="width: 100%;" onchange="btnSortstatus(this.value)">
                            <option value="all">Semua</option>
                            <option value="Belum Diajukan">Belum Diajukan</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="ml-auto p-2">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="pagination"> </ul>
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
        var order_by = 'kode_pesan';
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

        btnEdit = (kode_pesan) => {
            $.ajax({
                url: "<?php echo base_url('pemesananController/edit'); ?>",
                type: 'post',
                data: {
                    id: kode_pesan,
                },
                dataType: 'json',
                success: function(response) {
                    let data = response.data;
                    $('#id').val(data.id);
                    $('#kode_pesan_edit').val(data.kode_pesan);
                    $('#toko_edit').val(data.id_toko).change();
                    $('#tanggal_edit').val(data.tanggal);
                    $('#keterangan_edit').val(data.keterangan);

                    $('#formDataEdit').hide(100);
                    $('#formDataEdit').show(500);
                }
            });
        }

        closeEdit = () => {

            $('#formDataEdit').hide(500);
        }

        Datatable = () => {

            $.ajax({
                url: "<?php echo base_url('pemesananController/datatable'); ?>",
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
                                <th scope="col">KODE&nbsp;PEMESANAN</th>
                                <th scope="col">TANGGAL</th>
                                <th scope="col">TOKO</th>
                                <th scope="col">PEMESAN</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">KETERANGAN</th>
                                <th scope="col" width="220vw" class="text-center">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (response.recordsTotal == 0) {
                        dataTable = dataTable + `<td colspan="8" class="text-center">Data tidak ditemukan</td>`;

                    } else {
                        var no = response.offset;
                        for (let i = 0; i < data.length; i++) {
                            no++;
                            var btn_status = data[i].status == 'Belum Diajukan' ? 'btn-secondary' : data[i].status == 'Menunggu' ? 'btn-info' : data[i].status == 'Diterima' ? 'btn-success' : 'btn-danger';

                            var btn_disable = data[i].status == 'Menunggu' ? 'disabled' : data[i].status == 'Diterima' ? 'disabled' : '';

                            var btn_not_disable = data[i].status != 'Diterima' ? 'disabled' : '';

                            dataTable = dataTable + `<tr>
                                <th scope="row">${no}</th>
                                <td>${data[i].kode_pesan}</td>
                                <td>${data[i].tanggal}</td>
                                <td>${data[i].toko}</td>
                                <td>${data[i].pemesan}</td>
                                <td><button class="btn btn-sm ${btn_status}" >${data[i].status}</button></td>
                                <td><textarea cols="30" rows="1">${data[i].keterangan}</textarea></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" aria-pressed="true" title="Detail Data" data-toggle="collapse" aria-expanded="false" onclick="btnDetail('${data[i].kode_pesan}', ${data[i].id_toko}, '${btn_disable}')"><i class="far fa-folder-open"></i></button>

                                    <button type="button" class="btn btn-outline-success btn-sm" aria-pressed="true" title="Process To Submission" data-toggle="collapse" aria-expanded="false" ${btn_disable} onclick="btnSubmission('${data[i].kode_pesan}')"><i class="far fa-share-square"></i></button>

                                    <button type="button" class="btn btn-outline-warning btn-sm" aria-pressed="true" title="Print Data" data-toggle="collapse" aria-expanded="false" ${btn_not_disable} onclick="btnprint('${data[i].kode_pesan}')"><i class="fas fa-print"></i></i></button>

                                    <button type="button" class="btn btn-outline-primary btn-sm" aria-pressed="true" title="Edit data" data-toggle="collapse" aria-expanded="false" ${btn_disable} onclick="btnEdit('${data[i].kode_pesan}')"><i class="far fa-edit"></i></button>

                                   <a href="<?= base_url() ?>pemesananController/delete/${data[i].kode_pesan}" onclick="return confirm('Apa kamu yakin akan menghapus data item ini?');">
                                   <button type="button" class="btn btn-outline-danger btn-sm" aria-pressed="true" ${btn_disable} title="Hapus data" ><i class="far fa-trash-alt"></i></button>
                                   </a>
                                    
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

                    $('#pagination').html(dataPaging)

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
        // var sort_by_tgl_detail = 'all';

        btnDetail = (id, toko, disable) => {

            id_detail = id;
            DatatableDetail();
            DetailHeader(id)
            MasterBarang();

            var isDisable = disable == 'disabled' ? true : false;
            document.getElementById("simpan_detail").disabled = isDisable;

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

        btnSortTglDetail = (param) => {
            sort_by_tgl_detail = param;
            DatatableDetail();
        }

        DetailHeader = (kode_pesan) => {

            $.ajax({
                url: "<?php echo base_url('pemesananController/detailHeader'); ?>",
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
                    }
                }
            });
        }

        MasterBarang = () => {

            $.ajax({
                url: "<?php echo base_url('pemesananController/masterBarang'); ?>",
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        var barang_detail = '';
                        for (let i = 0; i < response.data.length; i++) {
                            barang_detail = barang_detail + `<option value="${response.data[i].id}">${response.data[i].barang} | ${response.data[i].satuan}</option>`;
                        }

                        $('#barang_detail').html(barang_detail);
                    }
                }
            });
        }

        DatatableDetail = () => {

            $.ajax({
                url: "<?php echo base_url('pemesananController/datatableDetail'); ?>",
                type: 'post',
                data: {
                    id: id_detail,
                    limit: limit_detail,
                    page: page_detail,
                    order_by: order_by_detail,
                    sort_by: sort_by_detail,
                    keyword: keyword_detail,
                    search_by: search_by_detail,
                    // sort_by_tgl: sort_by_tgl_detail,
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
                                <th scope="col" width="150vw" class="text-center">ACTION</th>
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
                            <td>${data[i].harga}</td>
                            <td>${data[i].total}</td>
                            <td><textarea cols="30" rows="1">${data[i].keterangan}</textarea></td>
                            <td class="text-center">

                            <button type="button" class="btn btn-outline-danger btn-sm" aria-pressed="true" title="Hapus data" ${disableButton} onclick="deleteDetail('${data[i].id}')"><i class="far fa-trash-alt"></i></button>
                                
                            </td> 
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

        insertDetail = () => {

            if ($('#barang_detail').val() == '' || $('#jumlah_detail').val() == '' || $('#harga_detail').val() == '' || $('#ket_detail').val() == '') {
                alert('Form input detail tidak boleh kosong');
                return false;
            }

            $.ajax({
                url: "<?php echo base_url('pemesananController/insertDetail'); ?>",
                type: 'post',
                data: {
                    kode_pesan: id_detail,
                    barang: $('#barang_detail').val(),
                    jumlah: $('#jumlah_detail').val(),
                    harga: $('#harga_detail').val(),
                    keterangan: $('#ket_detail').val(),
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert(response.message)
                        DatatableDetail();
                        $('#jumlah_detail').val('');
                        $('#harga_detail').val('');
                        $('#ket_detail').val('');
                    } else
                        alert(response.message)
                }
            });

        }

        deleteDetail = (id) => {

            if (confirm("Apakah anda yakin ingin menghapus ini ?")) {

                $.ajax({
                    url: "<?php echo base_url('pemesananController/deleteDetail'); ?>",
                    type: 'post',
                    data: {
                        kode_pesan: id_detail,
                        id: id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message)
                            DatatableDetail();
                        } else
                            alert(response.message)
                    }
                });
            }
        }

        getNoIdentitas = () => {

            $.ajax({
                url: "<?php echo base_url('pemesananController/getNoIdentitas'); ?>",
                type: 'post',
                dataType: 'text',
                success: function(response) {
                    $('#kode_pesan').val(response);
                }
            });
        }

        btnSubmission = (kode_pesan) => {

            $('#id_header_pesanan').val(kode_pesan);

            $('#formPengajuan').hide(100);
            $('#formPengajuan').show(500);
        }

        closeSubmission = () => {

            $('#formPengajuan').hide(500);
        }

        btnAjukanPesanan = (id_header) => {

            if ($('#pimpinan_terkait').val() == '') {
                alert('Form input Pengajuan tidak boleh kosong');
                return false;
            }

            $.ajax({
                url: "<?php echo base_url('pemesananController/insertPengajuan'); ?>",
                type: 'post',
                data: {
                    kode_pesan: $('#id_header_pesanan').val(),
                    pimpinan: $('#pimpinan_terkait').val(),
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
        }

        btnprint = (kode_pesan) => {

            var page = `<?php echo base_url('pemesananController/printData/'); ?>${kode_pesan}`;
            window.open(page);
        }
    </script>

</body>

<?php
$this->load->view('layouts/footer');
?>