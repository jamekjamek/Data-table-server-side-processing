<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />


    <title>Document</title>
</head>

<body>
    <div class="container mt-3">
        <h3>Datatable server-side codeigniter</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-2" onclick="add()">
            Tambah Data
        </button>
        <!-- <button type="button" class="btn btn-secondary mb-2" onclick="reloadTable()">
            Perbarui Halaman
        </button> -->


        <div class="card">
            <div class="card-body">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Depan</th>
                            <th>Nama Belakang</th>
                            <th>Alamat</th>
                            <th>No Hp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form_data" novalidate>
                        <input type="hidden" name="id" id="" value="">
                        <div class="form-group">
                            <label for="firstName">Nama Depan</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Masukan nama depan">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Nama Belakang</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Masukan nama belakang">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Alamat">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="mobilePhoneNumber">Nomor Handphone</label>
                            <input type="text" class="form-control" id="mobilePhoneNumber" name="mobilePhoneNumber" placeholder="Masukan nomor handphone">
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.14.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>



    <script>
        var table = $('#example')
        $(document).ready(function() {
            table.DataTable({
                "processing": true, //indikator load data
                "serverSide": true, //mode serverside
                "order": [],
                //load  ajax
                "ajax": {
                    "url": "<?= base_url('serverside/getdData'); ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "target": [-1], //last column,
                    "orderable": false
                }]
            });
        });

        var saveData;
        var formData = $('#form_data');
        var btnSave = $('#btnSave');
        var modalTitle = $('#modalTitle');
        var modal = $('#modalData');

        function deletequestion(id, name) {
            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan menghapus data" + name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.value) {
                    deleteData(id);
                }
            })
        }

        function message(icon, text) {
            Swal.fire({
                title: 'Data Karyawan',
                text: text,
                icon: icon,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }

        function add() {
            saveData = 'tambah';
            formData[0].reset();
            modal.modal('show');
            modalTitle.text('Tambah Data');
            btnSave.text('Simpan');
            btnSave.attr('disabled', false);
        }

        function reloadTable() {
            table.DataTable().ajax.reload(); //reload datatable ajax 
        }

        function save() {
            btnSave.text('Mohon tunggu...');
            btnSave.attr('disabled', true);
            if (saveData == 'tambah') {
                url = "<?= base_url('serverside/create'); ?>"
            } else {
                url = "<?= base_url('serverside/update'); ?>"
            }
            $.ajax({
                type: "POST",
                url: url,
                data: formData.serialize(),
                dataType: "JSON",
                success: function(response) {
                    if (response.status == 'success') {
                        modal.modal('hide');
                        reloadTable();
                        if (saveData == 'tambah') {
                            message('success', 'Tambah data sukses');
                        } else {
                            message('success', 'Ubah data sukses');
                        }
                    } else {
                        for (var i = 0; i < response.inputerror.length; i++) {
                            $('[name="' + response.inputerror[i] + '"]').addClass('is-invalid'); //select input error in class form-control
                            $('[name="' + response.inputerror[i] + '"]').next().text(response.error_string[i]); //select input error in 
                        }
                    }
                    btnSave.text('Simpan Data'); //change button text
                    btnSave.attr('disabled', false); //set button enable
                },
                error: function() {
                    message('error', 'Server bermasalah, Silahkan ulangi kembali');
                }
            });
        }

        function byId(id, type) {
            if (type == 'edit') {
                saveData = 'edit';
                formData[0].reset();
            }
            $.ajax({
                type: "GET",
                url: "<?= base_url('serverside/byid/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    if (type == 'edit') {
                        $('[name="id"]').val(response.id);
                        $('[name="firstName"]').val(response.nama_depan);
                        $('[name="lastName"]').val(response.nama_belakang);
                        $('[name="address"]').val(response.alamat);
                        $('[name="mobilePhoneNumber"]').val(response.no_hp);
                        formData.find('input').removeClass('is-invalid');
                        saveData = 'edit'
                        modal.modal('show'); // show bootstrap modal when complete loaded
                        btnSave.text('Update');
                        btnSave.attr('disabled', false);
                    } else {
                        deletequestion(response.id, response.nama_depan);
                    }
                }
            });
        }

        function deleteData(id) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('serverside/delete/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    if (response.status == 'success') {
                        reloadTable();
                        message('success', 'Delete data sukses');
                    }
                },
                error: function() {
                    message('error', 'Server bermasalah, Silahkan ulangi kembali');
                }
            });
        }
    </script>
</body>

</html>