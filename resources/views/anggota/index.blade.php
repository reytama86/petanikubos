@extends('layout.app')

@section('title', 'Data Kategori')

@section('content')

    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">
                Data Kategori
            </h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-4">
                <a href="#modal-form" class="btn btn-primary modal-tambah">Tambah Data</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-stripped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-kategori">
                                <div class="form-group">
                                    <label for="">Nama Anggota</label>
                                    <textarea name="nama_anggota" placeholder="Nama Anggota" class="form-control" id="" cols="30"
                                        rows="10" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Nama Anggota"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <textarea name="email" placeholder="Email" class="form-control" id="" cols="30" rows="10" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" placeholder="Alamat" class="form-control" id="" cols="30" rows="10"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {

            $.ajax({
                url: '/api/anggotaies',
                success: function({
                    data
                }) {
                    let row = '';
                    data.map(function(val, index) {
                        row += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${val.nama_anggota}</td>
                    <td>${val.username}</td>
                    <td>${val.email}</td>
                    <td>${val.alamat}</td>
                    <td>
                        <a data-toggle="modal" href="#modal-form" data-id="${val.id}" class="btn btn-warning modal-ubah">Edit</a>
                        <a href="#" data-id="${val.id}" class="btn btn-danger btn-hapus">Hapus</a>
                    </td>
                </tr>
            `;
                    });
                    $('tbody').append(row);
                }
            });

            $(document).on('click', '.btn-hapus', function() {
                const id = $(this).data('id');
                const token = localStorage.getItem('token');

                const confirm_dialog = confirm('Apakah anda yakin?');
                if (confirm_dialog) {
                    $.ajax({
                        url: '/api/anggotaies/' + id,
                        type: "DELETE",
                        headers: {
                            "Authorization": 'Bearer ' + token
                        },
                        success: function(data) {
                            if (data.message == 'success') {
                                alert('Data berhasil dihapus');
                                location.reload(); // Reload halaman jika sukses
                            }
                        }
                    });
                }
            });

            $('.modal-tambah').click(function() {
                $('#modal-form').modal('show');
                $('textarea[name="nama_anggota"]').val('');
                $('input[name="username"]').val('');
                $('textarea[name="email"]').val('');
                $('textarea[name="alamat"]').val('');

                $('.form-kategori').submit(function(e) {
                    e.preventDefault();
                    const token = localStorage.getItem('token');
                    const frmdata = new FormData(this);

                    $.ajax({
                        url: 'api/anggotaies',
                        type: 'POST',
                        data: frmdata,
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            "Authorization": 'Bearer ' + token
                        },
                        success: function(data) {
                            if (data.success) {
                                alert('Data berhasil ditambah');
                                location.reload(); // Reload halaman jika sukses
                            }
                        }
                    });
                });
            });

            $(document).on('click', '.modal-ubah', function() {
                $('#modal-form').modal('show');
                const id = $(this).data('id');

                $.get(`/api/anggotaies/${id}`, function({
                    data
                }) {
                    $('textarea[name="nama_anggota"]').val(data.nama_anggota);
                    $('input[name="username"]').val(data.username);
                    $('textarea[name="email"]').val(data.email);
                    $('textarea[name="alamat"]').val(data.alamat);
                });

                $('.form-kategori').submit(function(e) {
                    e.preventDefault();
                    const token = localStorage.getItem('token');
                    const frmdata = new FormData(this);

                    $.ajax({
                        url: `api/anggotaies/${id}?_method=PUT`,
                        type: 'POST',
                        data: frmdata,
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            "Authorization": 'Bearer ' + token
                        },
                        success: function(data) {
                            if (data.success) {
                                alert('Data berhasil diubah');
                                location.reload(); // Reload halaman jika sukses
                            }
                        }
                    });
                });
            });

        });
    </script>
@endpush
