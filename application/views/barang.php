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
            <h3>Master Barang</h3>
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
                            <span class="btn btn-success">Tambahkan data Barang</span>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('barangController/insert'); ?>
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <?php echo form_error('barang', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="barang" id="barang" value="<?php echo set_value('barang'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <?php echo form_error('satuan', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select class="form-control" name="satuan" id="satuan" value="<?php echo set_value('satuan'); ?>">
                                    <?php foreach ($satuan['data'] as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->satuan ?></option>
                                    <?php endforeach ?>
                                </select>

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
                            <span class="btn btn-primary">Edit data Barang</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;" onclick="closeEdit()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('barangController/update'); ?>
                            <input type="hidden" class="form-control" name="id" id="id" value="<?php echo set_value('id'); ?>" />
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <?php echo form_error('barang_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="barang_edit" id="barang_edit" value="<?php echo set_value('barang_edit'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <?php echo form_error('satuan_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select class="form-control" name="satuan_edit" id="satuan_edit" value="<?php echo set_value('satuan_edit'); ?>">
                                    <?php foreach ($satuan['data'] as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->satuan ?></option>
                                    <?php endforeach ?>
                                </select>

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
                            <span class="btn btn-secondary">Detail Data Barang</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;" onclick="closeDetail()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nama Barang</label>
                                        <input type="text" class="form-control" name="barang_detail" id="barang_detail" autocomplete="off" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Satuan Barang</label>
                                        <select class="form-control" name="satuan_detail" id="satuan_detail" disabled>
                                            <?php foreach ($satuan['data'] as $row) : ?>
                                                <option value="<?= $row->id ?>"><?= $row->satuan ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-secondary mb-2" onclick="insertDetail()">Simpan Detail</button>
                                    <button type="button" class="btn btn-secondary mb-2" onclick="getNoIdentitas()">Generate NoID</button>

                                </div>
                                <div class="col-md-9 card bg-secondary">
                                    <div class="row card-body text-white">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Identitas</label>
                                                <input type="text" class="form-control" name="no_id" id="no_id" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tgl Masuk</label>
                                                <input type="date" class="form-control" name="tgl_masuk_detail" id="tgl_masuk_detail" autocomplete="off" />
                                            </div>

                                        </div>
                                        <div class="col-md-12">
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
                                                <div class="p-2">
                                                    <select class="form-control" style="width: 100%;" onchange="btnSortTglDetail(this.value)">
                                                        <option value="all">Semua</option>
                                                        <option value="stock">Tersedia</option>
                                                        <option value="stock_out">Sudah Keluar</option>
                                                    </select>
                                                </div>
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
                            <option value="barang">BARANG</option>
                            <option value="satuan">SATUAN</option>
                        </select>
                    </div>
                    <div class="p-2">
                        <input type="text" class="form-control" id="pencarian" placeholder="Pencarian" onkeyup="pencarian(this.value)" />
                    </div>
                </div>
                <div id="dataTable" style="height: 49vh;overflow-x:auto;overflow-y:auto;"></div>
                <div class="d-flex">
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
        var order_by = 'id';
        var keyword = '';
        var search_by = 'barang';

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

        btnEdit = (id) => {
            $.ajax({
                url: "<?php echo base_url('barangController/edit'); ?>",
                type: 'post',
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function(response) {
                    let data = response.data;
                    $('#id').val(data.id);
                    $('#barang_edit').val(data.barang);
                    $('#satuan_edit').val(data.id_satuan).change();

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
                url: "<?php echo base_url('barangController/datatable'); ?>",
                type: 'post',
                data: {
                    limit: limit,
                    page: page,
                    order_by: order_by,
                    sort_by: sort_by,
                    keyword: keyword,
                    search_by: search_by
                },
                dataType: 'json',
                success: function(response) {

                    //TODO ===== DataTable ======

                    let data = response.data;
                    let dataTable = `<table class="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="60vw">#</th>
                                <th scope="col">BARANG</th>
                                <th scope="col">SATUAN</th>
                                <th scope="col">JUMLAH</th>
                                <th scope="col" width="150vw" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (response.recordsTotal == 0) {
                        dataTable = dataTable + `<td colspan="5" class="text-center">Data tidak ditemukan</td>`;

                    } else {
                        var no = response.offset;
                        for (let i = 0; i < data.length; i++) {
                            no++;
                            dataTable = dataTable + `<tr>
                                <th scope="row">${no}</th>
                                <td>${data[i].barang}</td>
                                <td>${data[i].satuan}</td>
                                <td>${data[i].jumlah_barang}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" aria-pressed="true" title="Detail Data" data-toggle="collapse" aria-expanded="false" onclick="btnDetail(${data[i].id}, '${data[i].barang}', ${data[i].id_satuan})"><i class="far fa-folder-open"></i></button>

                                    <button type="button" class="btn btn-outline-primary btn-sm" aria-pressed="true" title="Edit data" data-toggle="collapse" aria-expanded="false" onclick="btnEdit(${data[i].id})"><i class="far fa-edit"></i></button>

                                   <a href="<?= base_url() ?>barangController/delete/${data[i].id}" onclick="return confirm('Apa kamu yakin akan menghapus data item ini?');">
                                   <button type="button" class="btn btn-outline-danger btn-sm" aria-pressed="true" title="Hapus data" ><i class="far fa-trash-alt"></i></button>
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
        var order_by_detail = 'tgl_masuk';
        var keyword_detail = '';
        var search_by_detail = 'no_identitas';
        var sort_by_tgl_detail = 'all';

        btnDetail = (id, barang, satuan) => {

            id_detail = id;
            DatatableDetail();

            $('#barang_detail').val(barang);
            $('#satuan_detail').val(satuan).change();

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

        DatatableDetail = () => {

            $.ajax({
                url: "<?php echo base_url('barangController/datatableDetail'); ?>",
                type: 'post',
                data: {
                    id: id_detail,
                    limit: limit_detail,
                    page: page_detail,
                    order_by: order_by_detail,
                    sort_by: sort_by_detail,
                    keyword: keyword_detail,
                    search_by: search_by_detail,
                    sort_by_tgl: sort_by_tgl_detail,
                },
                dataType: 'json',
                success: function(response) {

                    //TODO ===== DataTable ======

                    let data = response.data;
                    let dataTable = `<table class="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="60vw">#</th>
                                <th>NO.&nbsp;IDENTITAS</th>
                                <th>TGL.&nbsp;MASUK</th>
                                <th>TGL.&nbsp;KELUAR</th>
                                <th>KETERANGAN</th>
                                <th scope="col" width="150vw" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-light">`;
                    if (response.recordsTotal == 0) {
                        dataTable = dataTable + `<td colspan="6" class="text-center">Data tidak ditemukan</td>`;

                    } else {
                        var no = response.offset;
                        for (let i = 0; i < data.length; i++) {
                            no++;
                            var disableButton = data[i].tgl_keluar != null ? 'disabled' : ''
                            dataTable = dataTable + `<tr>
                            <th scope="row">${no}</th>
                            <td>${data[i].no_identitas}</td>
                            <td>${data[i].tgl_masuk}</td>
                            <td>${data[i].tgl_keluar != null ? data[i].tgl_keluar : ''}</td>
                            <td>${data[i].keterangan}</td>
                            <td class="text-center">

                            <button type="button" class="btn btn-outline-primary btn-sm" aria-pressed="true" title="Unduh Qr Code" onclick="qrCodeDetail('${data[i].no_identitas}')"><i class="fas fa-qrcode"></i></button>

                            <button type="button" class="btn btn-outline-danger btn-sm" aria-pressed="true" title="Hapus data" ${disableButton} onclick="deleteDetail('${data[i].no_identitas}')"><i class="far fa-trash-alt"></i></button>
                                
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

            if ($('#no_id').val() == '' || $('#tgl_masuk_detail').val() == '' || $('#ket_detail').val() == '') {
                alert('Form input detail tidak boleh kosong');
                return false;
            }

            $.ajax({
                url: "<?php echo base_url('barangController/insertDetail'); ?>",
                type: 'post',
                data: {
                    id_barang: id_detail,
                    no_id: $('#no_id').val(),
                    tgl_masuk: $('#tgl_masuk_detail').val(),
                    keterangan: $('#ket_detail').val(),
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert(response.message)
                        DatatableDetail();
                        Datatable();
                        $('#no_id').val('');
                        $('#tgl_masuk_detail').val('');
                        $('#ket_detail').val('');
                    } else
                        alert(response.message)
                }
            });

        }

        deleteDetail = (no_id) => {

            if (confirm("Apakah anda yakin ingin menghapus ini ?")) {

                $.ajax({
                    url: "<?php echo base_url('barangController/deleteDetail/'); ?>",
                    type: 'post',
                    data: {
                        id_barang: id_detail,
                        no_id: no_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message)
                            DatatableDetail();
                            Datatable();
                        } else
                            alert(response.message)
                    }
                });
            }
        }

        getNoIdentitas = () => {

            $.ajax({
                url: "<?php echo base_url('barangController/getNoIdentitas'); ?>",
                type: 'post',
                dataType: 'text',
                success: function(response) {
                    $('#no_id').val(response);
                }
            });
        }

        qrCodeDetail = (NoID) => {

            var page = `<?php echo base_url('barangController/download_qrcode'); ?>?data=${NoID}`;
            window.open(page);
        }
    </script>

</body>

<?php
$this->load->view('layouts/footer');
?>