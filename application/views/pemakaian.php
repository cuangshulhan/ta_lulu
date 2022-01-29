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
            <h3>Transaksi Pemakaian</h3>
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
                            <span class="btn btn-success">Tambahkan data Pemakaian</span>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('pemakaianController/insert'); ?>
                            <div class="form-group">
                                <label>Nama Kendaraan</label>
                                <?php echo form_error('kendaraan', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select class="form-control" name="kendaraan" id="kendaraan" value="<?php echo set_value('kendaraan'); ?>" required>
                                    <option selected>Select an option</option>
                                    <?php foreach ($kendaraan['data'] as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->plat ?> | <?= $row->merek ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <?php echo form_error('barang', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select class="form-control" name="barang" id="barang" value="<?php echo set_value('barang'); ?>" onchange="getDetailBarang(this.value)" required>
                                    <option selected>Select an option</option>
                                    <?php foreach ($barang['data'] as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->barang ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>No Identitas</label>
                                <?php echo form_error('no_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select class="form-control" name="no_id" id="no_id" value="<?php echo set_value('no_id'); ?>" required></select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <?php echo form_error('tanggal', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo set_value('tanggal'); ?>" autocomplete="off" required/>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <?php echo form_error('keterangan', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <textarea  class="form-control" name="keterangan" id="keterangan" cols="30" rows="10"><?php echo set_value('keterangan'); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            </form>
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
                            <option value="plat">KENDARAAN</option>
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

        Datatable = () => {

            $.ajax({
                url: "<?php echo base_url('pemakaianController/datatable'); ?>",
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
                                <th scope="col">NAMA&nbsp;KENDARAAN</th>
                                <th scope="col">NAMA&nbsp;BARANG</th>
                                <th scope="col">NO&nbsp;ID&nbsp;BARANG</th>
                                <th scope="col">TGL&nbsp;PEMAKAIAN</th>
                                <th scope="col">KETERANGAN</th>
                                <th scope="col" width="150vw" class="text-center">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (response.recordsTotal == 0) {
                        dataTable = dataTable + `<td colspan="8" class="text-center">Data tidak ditemukan</td>`;

                    } else {
                        var no = response.offset;
                        for (let i = 0; i < data.length; i++) {
                            no++;
                            dataTable = dataTable + `<tr>
                                <th scope="row">${no}</th>
                                <td>${data[i].plat} | ${data[i].merek}</td>
                                <td>${data[i].barang}</td>
                                <td>${data[i].no_identitas}</td>
                                <td>${data[i].tanggal}</td>
                                <td>${data[i].keterangan}</td>
                                <td class="text-center">

                                   <a href="<?= base_url() ?>pemakaianController/delete/${data[i].id}/${data[i].id_barang}/${data[i].no_identitas}" onclick="return confirm('Apa kamu yakin akan menghapus data item ini?');">
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

        getDetailBarang = (id_barang) => {

            $.ajax({
                url: "<?php echo base_url('pemakaianController/getDetailBarang'); ?>",
                type: 'post',
                data:{id_barang:id_barang},
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    var option = '';
                    for (let i = 0; i < response.data.length; i++) {
                        option = option + ` <option value="${response.data[i].no_identitas}">${response.data[i].no_identitas}</option>`;
                    }

                    $('#no_id').html(option);
                }
            });
        }
    </script>

</body>

<?php
$this->load->view('layouts/footer');
?>