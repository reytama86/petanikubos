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
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-kategori">
                            <div class="form-group">
                                <label for="">Nama Kategori</label>
                                <input type="text" class="form-control" name="nama_kategori" id="" placeholder="Nama Kategori" required>
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
    $(document).ready(function() {
        // Fungsi untuk menampilkan data kategori saat halaman dimuat
        function loadData() {
            $.ajax({
                url: '/api/categories',
                success: function({ data }) {
                    let row = '';
                    data.map(function(val, index) {
                        row += `
                            <tr>
                               <td>${index + 1}</td>
                               <td>${val.nama_kategori}</td>
                               <td>
                                    <a data-toggle="modal" href="#modal-form" data-id="${val.id_kategori}" class="btn btn-warning modal-ubah">Edit</a>
                                    <a href="#" data-id="${val.id_kategori}" class="btn btn-danger btn-hapus">Hapus</a>
                                </td>
                            </tr>
                        `;
                    });
                    $('tbody').html(row); // Mengganti seluruh isi tbody dengan data yang baru
                }
            });
        }

        // Memanggil fungsi untuk menampilkan data kategori saat halaman dimuat
        loadData();

        $('.modal-tambah').click(function() {
            $('#modal-form').modal('show');
            $('input[name="nama_kategori"]').val('');

            $('.form-kategori').off('submit').on('submit', function(e) {
                e.preventDefault();
                const token = localStorage.getItem('token');
                const frmdata = new FormData(this);

                $.ajax({
                    url: '/api/categories',
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

        // Menangani pengiriman form untuk edit kategori
        $(document).on('click', '.modal-ubah', function() {
            $('#modal-form').modal('show');
            const id = $(this).data('id');

            $.get(`/api/categories/${id}`, function({ data }) {
                $('input[name="nama_kategori"]').val(data.nama_kategori);
            });

            $('.form-kategori').off('submit').on('submit', function(e) {
                e.preventDefault();
                const token = localStorage.getItem('token');
                const frmdata = new FormData(this);

                $.ajax({
                    url: `/api/categories/${id}?_method=PUT`,
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

        // Menangani klik tombol hapus
        $(document).on('click', '.btn-hapus', function() {
            const id = $(this).data('id');
            const token = localStorage.getItem('token');

            const confirm_dialog = confirm('Apakah anda yakin?');
            if (confirm_dialog) {
                $.ajax({
                    url: '/api/categories/' + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": 'Bearer ' + token
                    },
                    success: function(data) {
                        if (data.success) {
                            alert('Data berhasil dihapus');
                            loadData(); // Memuat kembali data kategori setelah penghapusan
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
