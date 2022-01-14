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
            $show_change_pw = '';
        } elseif ($valid_error == 'update') {
            $show_edit = 'show';
            $show = '';
            $show_change_pw = '';
        } elseif ($valid_error == 'changePassword') {
            $show_change_pw = 'show';
            $show_edit = '';
            $show = '';
        }
    } else {
        $show = '';
        $show_edit = '';
        $show_change_pw = '';
    }

    ?>
    <div class="container-fluid mt-4 mb-4">

        <center>
            <h3>Master Pengguna</h3>
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
                            <span class="btn btn-success">Tambahkan data Pengguna</span>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('penggunaController/insert'); ?>
                            <div class="form-group">
                                <label>Username</label>
                                <?php echo form_error('username', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <?php echo form_error('password', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Fullname</label>
                                <?php echo form_error('fullname', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo set_value('fullname'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Level</label>
                                <?php echo form_error('level', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select name="level" id="level" class="form-control" value="<?php echo set_value('level'); ?>">
                                    <option value="super_admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="user">User</option>
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
                            <span class="btn btn-primary">Edit data Pengguna</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;" onclick="closeEdit()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('penggunaController/update'); ?>
                            <input type="hidden" class="form-control" name="id" id="id" value="<?php echo set_value('id'); ?>" />
                            <div class="form-group">
                                <label>Username</label>
                                <?php echo form_error('username_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="username_edit" id="username_edit" value="<?php echo set_value('username_edit'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Fullname</label>
                                <?php echo form_error('fullname_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="fullname_edit" id="fullname_edit" value="<?php echo set_value('fullname_edit'); ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Level</label>
                                <?php echo form_error('level_edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <select name="level_edit" id="level_edit" class="form-control" value="<?php echo set_value('level_edit'); ?>">
                                    <option value="super_admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TODO ================== Form Change Password ==========================-->

        <div class=" row">
            <div class="col">
                <div class="collapse mb-4 <?= $show_change_pw ?>" id="formDataChangePassword">
                    <div class="card">
                        <div class="card-header bg-warning">
                            <span class="btn btn-warning">Ganti Password Pengguna</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;" onclick="closeChangePassword()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('penggunaController/changePassword'); ?>
                            <input type="hidden" class="form-control" name="id_change" id="id_change" value="<?php echo set_value('id'); ?>" />
                            <div class="form-group">
                                <label>Username</label>
                                <?php echo form_error('username_change', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="username_change" id="username_change" value="<?php echo set_value('username_change'); ?>" autocomplete="off" readonly />
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <?php echo form_error('password_change', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                                <input type="text" class="form-control" name="password_change" id="password_change" value="<?php echo set_value('password_change'); ?>" autocomplete="off" />
                            </div>
                            <button type="submit" class="btn btn-warning">Simpan Password Baru</button>
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
                            <option value="username">USERNAME</option>
                            <option value="fullname">FULLNAME</option>
                            <option value="level">LEVEL</option>
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
        var search_by = 'username';

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
                url: "<?php echo base_url('penggunaController/edit'); ?>",
                type: 'post',
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function(response) {
                    let data = response.data;
                    $('#id').val(data.id);
                    $('#username_edit').val(data.username);
                    $('#fullname_edit').val(data.fullname);
                    $('#level_edit').val(data.level).change();

                    $('#formDataEdit').hide(100);
                    $('#formDataEdit').show(500);
                }
            });
        }

        closeEdit = () => {

            $('#formDataEdit').hide(500);
        }

        btnChangePassword = (id, username) => {

            $('#id_change').val(id);
            $('#username_change').val(username);
            $('#formDataChangePassword').hide(100);
            $('#formDataChangePassword').show(500);
        }

        closeChangePassword = () => {

            $('#formDataChangePassword').hide(500);
        }

        Datatable = () => {

            $.ajax({
                url: "<?php echo base_url('penggunaController/datatable'); ?>",
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
                                <th scope="col">USERNAME</th>
                                <th scope="col">FULLNAME</th>
                                <th scope="col">LEVEL</th>
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
                                <td>${data[i].username}</td>
                                <td>${data[i].fullname}</td>
                                <td>${data[i].level}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm" aria-pressed="true" title="Edit data" data-toggle="collapse" aria-expanded="false" onclick="btnEdit(${data[i].id})"><i class="far fa-edit"></i></button>
                                
                                    <button type="button" class="btn btn-outline-warning btn-sm" aria-pressed="true" title="Change Password" data-toggle="collapse" aria-expanded="false" onclick="btnChangePassword(${data[i].id},'${data[i].username}')"><i class="fas fa-exchange-alt"></i></button>

                                   <a href="<?= base_url() ?>penggunaController/delete/${data[i].id}" onclick="return confirm('Apa kamu yakin akan menghapus data item ini?');">
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