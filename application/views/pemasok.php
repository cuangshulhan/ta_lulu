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
            <h3>Master Pemasok</h3>
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
                            <span class="btn btn-success">Tambahkan data Pemasok</span>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('pemasokController/insert'); ?>
                            <div class="form-group">
                                <div class="d-flex justify-content-around">
                                    <label>Nama PT</label>
                                    <span style="width: 10vw;"></span>
                                    <label>No. Telepon</label>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <?php echo form_error('nama', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                    <span style="width: 10vw;"></span>
                                    <?php echo form_error('telp', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo set_value('nama'); ?>" autocomplete="off" />
                                    <span style="width: 10vw;"></span>
                                    <input type="text" class="form-control" name="telp" id="telp" value="<?php echo set_value('telp'); ?>" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-around">
                                    <label>NPWP</label>
                                    <span style="width: 10vw;"></span>
                                    <label>Nama PIC</label>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <?php echo form_error('npwp', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                    <span style="width: 10vw;"></span>
                                    <?php echo form_error('pic', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <input type="text" class="form-control" name="npwp" id="npwp" value="<?php echo set_value('npwp'); ?>" autocomplete="off" />
                                    <span style="width: 10vw;"></span>
                                    <input type="text" class="form-control" name="pic" id="pic" value="<?php echo set_value('pic'); ?>" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-around">
                                    <label>Alamat Perusahan</label>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <?php echo form_error('alamat', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="2"><?php echo set_value('alamat'); ?></textarea>
                                </div>
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
                            <span class="btn btn-primary">Edit data Pemasok</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;" onclick="closeEdit()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('pemasokController/update'); ?>
                            <input type="hidden" class="form-control" name="id" id="id" value="<?php echo set_value('id'); ?>" />
                            <div class="form-group">
                                <div class="d-flex justify-content-around">
                                    <label>Nama PT</label>
                                    <span style="width: 10vw;"></span>
                                    <label>No. Telepon</label>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <?php echo form_error('nama_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                    <span style="width: 10vw;"></span>
                                    <?php echo form_error('telp_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <input type="text" class="form-control" name="nama_edit" id="nama_edit" value="<?php echo set_value('nama_edit'); ?>" autocomplete="off" />
                                    <span style="width: 10vw;"></span>
                                    <input type="text" class="form-control" name="telp_edit" id="telp_edit" value="<?php echo set_value('telp_edit'); ?>" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-around">
                                    <label>NPWP</label>
                                    <span style="width: 10vw;"></span>
                                    <label>Nama PIC</label>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <?php echo form_error('npwp_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                    <span style="width: 10vw;"></span>
                                    <?php echo form_error('pic_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <input type="text" class="form-control" name="npwp_edit" id="npwp_edit" value="<?php echo set_value('npwp_edit'); ?>" autocomplete="off" />
                                    <span style="width: 10vw;"></span>
                                    <input type="text" class="form-control" name="pic_edit" id="pic_edit" value="<?php echo set_value('pic_edit'); ?>" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-around">
                                    <label>Alamat Perusahan</label>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <?php echo form_error('alamat_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <textarea class="form-control" name="alamat_edit" id="alamat_edit" cols="30" rows="2"><?php echo set_value('alamat_edit'); ?></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
                            <option value="nama">NAMA PT</option>
                            <option value="telp">TELP</option>
                            <option value="npwp">NPWP</option>
                        </select>
                    </div>
                    <div class="p-2">
                        <input type="text" class="form-control" id="pencarian" placeholder="Pencarian" onkeyup="pencarian(this.value)" />
                    </div>
                </div>
                <div id="dataTable" style="overflow-x:auto;"></div>
                <div class="d-flex">
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
        var search_by = 'nama';

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
                url: "<?php echo base_url('pemasokController/edit'); ?>",
                type: 'post',
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function(response) {
                    let data = response.data;
                    $('#id').val(data.id);
                    $('#nama_edit').val(data.nama);
                    $('#telp_edit').val(data.telp);
                    $('#npwp_edit').val(data.npwp);
                    $('#pic_edit').val(data.pic);
                    $('#alamat_edit').val(data.alamat);

                    $('#formDataEdit').hide(100);
                    $('#formDataEdit').show(500);
                }
            });
        }

        closeEdit = () => {

            $('#formDataEdit').hide(500);
            showEdit = false;
        }

        Datatable = () => {

            $.ajax({
                url: "<?php echo base_url('pemasokController/datatable'); ?>",
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
                                <th scope="col">Nama&nbsp;Perusahaan</th>
                                <th scope="col">Telepon</th>
                                <th scope="col">No.&nbsp;Wajib&nbsp;Pajak</th>
                                <th scope="col">Nama&nbsp;PIC</th>
                                <th scope="col">Alamat&nbsp;Perusahaan</th>
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
                                <td>${data[i].nama}</td>
                                <td>${data[i].telp}</td>
                                <td>${data[i].npwp}</td>
                                <td>${data[i].pic}</td>
                                <td><textarea class="form-control" cols="30" rows="1">${data[i].alamat}</textarea></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm" aria-pressed="true" title="Edit data" data-toggle="collapse" aria-expanded="false" onclick="btnEdit(${data[i].id})"><i class="far fa-edit"></i></button>

                                   <a href="<?= base_url() ?>pemasokController/delete/${data[i].id}" onclick="return confirm('Apa kamu yakin akan menghapus data item ini?');">
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

                    $('.pagination').html(dataPaging)

                    //TODO ===== END Pagination ======
                }
            });
        }
    </script>

</body>

<?php
$this->load->view('layouts/footer');
?>