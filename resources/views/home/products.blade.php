@extends('layout.home')

@section('title', 'List Product')

@section('content')


    <form id="searchForm">
        @csrf
        <input type="text" id="searchInput" class="form-control" placeholder="Search by Product Name...">
        <button type="button" id="searchButton" class="btn btn-primary">Search</button>
    </form>
    <div id="result"></div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                var searchTerm = $('#searchInput').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('product.search') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: searchTerm
                    },
                    success: function(data) {
                        var products = data.products;
                        var result = '<h2>Search Results</h2>';

                        if (products.length > 0) {
                            result += '<div class="row">';
                            products.forEach(function(product) {
                                result +=
                                    '<div class="col-md-4 col-xs-6 product product-grid">';
                                result += '<div class="product-item clearfix">';
                                result += '<div class="product-img hover-trigger">';
                                result += '<a href="/product/' + product.id + '">';
                                result += '<img src="/uploads/' + product.gambar +
                                    '" alt="">';
                                result += '<img src="/uploads/' + product.gambar +
                                    '" alt="" class="back-img">';
                                result += '</a>';
                                result += '<div class="hover-2">';
                                result += '<div class="product-actions">';
                                result +=
                                '<a href="#" class="product-add-to-wishlist">';
                                result += '<i class="fa fa-heart"></i>';
                                result += '</a>';
                                result += '</div>';
                                result += '</div>';
                                result += '<a href="/product/' + product.id +
                                    '" class="product-quickview">More</a>';
                                result += '</div>';
                                result += '<div class="product-details">';
                                result += '<h3 class="product-title">';
                                result += '<a href="/product/' + product.id + '">' +
                                    product.nama_barang + '</a>';
                                result += '</h3>';
                                result += '<span class="category">';
                                result += '</span>';
                                result += '</div>';
                                result += '<span class="amount">Rp ' + new Intl.NumberFormat().format(product.harga) + '</span>';
                                result += '<span class="price">';
                                result += '<ins>';
                                result += '</ins>';
                                result += '</span>';
                                result += '</div>';
                                result += '</div>';
                                result += '</div>';
                            });
                            result += '</div>';
                        } else {
                            result += '<p>No products found.</p>';
                        }

                        $('#result').html(result);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>


    <!-- Catalogue -->
    <section class="section-wrap pt-80 pb-40 catalogue">
        <div class="container relative">

            <!-- Filter -->
            <div class="shop-filter">
                <div class="view-mode hidden-xs">
                    <span>View:</span>
                    <a class="grid grid-active" id="grid"></a>
                    <a class="list" id="list"></a>
                </div>
                <div class="filter-show hidden-xs">
                    <span>Show:</span>
                    <a href="#" class="active">12</a>
                    <a href="#">24</a>
                    <a href="#">all</a>
                </div>
                <form class="ecommerce-ordering">
                    <select>
                        <option value="default-sorting">Default Sorting</option>
                        <option value="price-low-to-high">Price: high to low</option>
                        <option value="price-high-to-low">Price: low to high</option>
                        <option value="by-popularity">By Popularity</option>
                        <option value="date">By Newness</option>
                        <option value="rating">By Rating</option>
                    </select>
                </form>
            </div>

            <div class="row">
                <div class="col-md-12 catalogue-col right mb-50">
                    <div class="shop-catalogue grid-view">

                        <div class="row items-grid">

                            @foreach ($products as $product)
                                <div class="col-md-4 col-xs-6 product product-grid">
                                    <div class="product-item clearfix">
                                        <div class="product-img hover-trigger">
                                            <a href="/product/{{ $product->id_produk }}">
                                                <img src="/uploads/{{ $product->gambar }}" alt="">
                                                <img src="/uploads/{{ $product->gambar }}" alt="" class="back-img">
                                            </a>
                                            <div class="hover-2">
                                                <div class="product-actions">
                                                    <a href="#" class="product-add-to-wishlist">
                                                        <i class="fa fa-heart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="/product/{{ $product->id_produk }}" class="product-quickview">More</a>
                                        </div>

                                        <div class="product-details">
                                            <h3 class="product-title">
                                                <a href="/product/{{ $product->id_produk }}">{{ $product->nama_produk }}</a>
                                            </h3>
                                            {{-- <span class="category">
                                                <a
                                                    href="/product/{{ $product->id_kategori }}">{{ $product->category->nama_kategori }}</a>
                                            </span> --}}
                                        </div>

                                        <span class="price">
                                            <ins>
                                                <span class="amount">{{ 'Rp' . number_format($product->harga) }}</span>
                                            </ins>
                                        </span>
                                    </div>
                                </div> <!-- end product -->
                            @endforeach
                        </div> <!-- end row -->
                    </div> <!-- end grid mode -->

                    <!-- Pagination -->
                    <div class="pagination-wrap clearfix">
                        <p class="result-count">Showing: 12 of 80 results</p>
                        <nav class="pagination right clearfix">
                            <a href="#"><i class="fa fa-angle-left"></i></a>
                            <span class="page-numbers current">1</span>
                            <a href="#">2</a>
                            <a href="#">3</a>
                            <a href="#">4</a>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </nav>
                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </section> <!-- end catalog -->
@endsection
