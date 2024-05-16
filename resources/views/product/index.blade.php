@extends('layout.app')

@section('title', 'Data Produk')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Data Produk
        </h4>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-4">
            <a href="#modal-form" class="btn btn-primary modal-tambah">Tambah Produk</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Diskripsi</th>
                        <th>Total Jual</th>
                        <th>Kategori</th>
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
                <h5 class="modal-title">Form Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-produk">
                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" id="" placeholder="Nama Produk" required>
                            </div>
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input type="number" class="form-control" name="harga" id="" placeholder="Harga" required>
                            </div>
                            <div class="form-group">
                                <label for="">Diskripsi</label>
                                <textarea class="form-control" name="diskripsi" placeholder="Diskripsi" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Total Jual</label>
                                <input type="number" class="form-control" name="total_jual" id="" placeholder="Total Jual">
                            </div>
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select class="form-control" name="id_kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id_kategori }}">{{ $category->nama_kategori }}</option>
                                    @endforeach
                                </select>
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
        // Fungsi untuk menampilkan data produk saat halaman dimuat
        function loadData() {
            $.ajax({
                url: '/api/products',
                success: function({ data }) {
                    let row = '';
                    data.map(function(val, index) {
                        row += `
                            <tr>
                               <td>${index + 1}</td>
                               <td>${val.nama_produk}</td>
                               <td>${val.harga}</td>
                               <td>${val.diskripsi}</td>
                               <td>${val.total_jual}</td>
                               <td>${val.category.nama_kategori}</td>
                               <td>
                                    <a data-toggle="modal" href="#modal-form" data-id="${val.id_produk}" class="btn btn-warning modal-ubah">Edit</a>
                                    <a href="#" data-id="${val.id_produk}" class="btn btn-danger btn-hapus">Hapus</a>
                                </td>
                            </tr>
                        `;
                    });
                    $('tbody').html(row); // Mengganti seluruh isi tbody dengan data yang baru
                }
            });
        }

        // Memanggil fungsi untuk menampilkan data produk saat halaman dimuat
        loadData();

        $('.modal-tambah').click(function() {
            $('#modal-form').modal('show');
            $('input[name="nama_produk"]').val('');
            $('input[name="harga"]').val('');
            $('textarea[name="diskripsi"]').val('');
            $('input[name="total_jual"]').val('');
            $('select[name="id_kategori"]').val('');

            $('.form-produk').off('submit').on('submit', function(e) {
                e.preventDefault();
                const token = localStorage.getItem('token');
                const frmdata = new FormData(this);

                $.ajax({
                    url: '/api/products',
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
                            alert('Produk berhasil ditambah');
                            location.reload(); // Reload halaman jika sukses
                        }
                    }
                });
            });
        });

        // Menangani pengiriman form untuk edit produk
        $(document).on('click', '.modal-ubah', function() {
            $('#modal-form').modal('show');
            const id = $(this).data('id');

            $.get(`/api/products/${id}`, function({ data }) {
                $('input[name="nama_produk"]').val(data.nama_produk);
                $('input[name="harga"]').val(data.harga);
                $('textarea[name="diskripsi"]').val(data.diskripsi);
                $('input[name="total_jual"]').val(data.total_jual);
                $('select[name="id_kategori"]').val(data.id_kategori);
            });

            $('.form-produk').off('submit').on('submit', function(e) {
                e.preventDefault();
                const token = localStorage.getItem('token');
                const frmdata = new FormData(this);

                $.ajax({
                    url: `/api/products/${id}?_method=PUT`,
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
                            alert('Produk berhasil diubah');
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
                    url: '/api/products/' + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": 'Bearer ' + token
                    },
                    success: function(data) {
                        if (data.success) {
                            alert('Produk berhasil dihapus');
                            loadData(); // Memuat kembali data produk setelah penghapusan
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
