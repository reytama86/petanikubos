@extends('layout.home')

@section('title', 'Cart')

@section('content')

    <!-- Cart -->
    <section class="section-wrap shopping-cart">
        <div class="container relative">
            <form class="form-cart">
                <input type="hidden" name="id_member" value="{{ Auth::guard('webmember')->user()->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap mb-30">
                            <table class="shop_table cart table">
                                <thead>
                                    <tr>
                                        <th class="product-name" colspan="2">product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal" colspan="2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)
                                        <input type="hidden" name="id_product[]" value="{{ $cart->product->id }}">
                                        <input type="hidden" name="jumlah[]" value="{{ $cart->jumlah }}">
                                        <input type="hidden" name="total[]" value="{{ $cart->total }}">
                                        <tr class="cart_item">
                                            <td class="product-thumbnail">
                                                <a href="#">
                                                    <img src="/uploads/{{ $cart->product->gambar }}" alt="">
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="#">{{ $cart->product->nama_barang }}</a>
                                                <ul>
                                                    <li>{{ $cart->size }}</li>
                                                    <li>{{ $cart->color }}</li>
                                                </ul>
                                            </td>
                                            <td class="product-price">
                                                <span
                                                    class="amount">{{ 'Rp . ' . number_format($cart->product->harga) }}</span>
                                            </td>
                                            <td class="product-quantity">
                                                <span class="amount">{{ $cart->jumlah }}</span>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount">{{ 'Rp . ' . number_format($cart->total) }}</span>
                                            </td>
                                            <td class="product-remove">
                                                <a href="/delete_from_cart/{{ $cart->id }}" class="remove"
                                                    title="Remove this item">
                                                    <i class="ui-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mb-50">
                            <div class="col-md-5 col-sm-12">
                            </div>
                            <div class="col-md-7">
                                <div class="actions">
                                    <div class="wc-proceed-to-checkout">
                                        <a href="#" class="btn btn-lg btn-dark checkout"><span>proceed to
                                                checkout</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end col -->
                </div> <!-- end row -->

                <div class="row">
                    <div class="col-md-6 shipping-calculator-form">
                        <h2 class="heading relative uppercase bottom-line full-grey mb-30">Calculate Shipping</h2>
                        <p class="form-row form-row-wide">
                            <select name="kota" id="kota" class="country_to_state kota" rel="calc_shipping_state">

                            </select>
                        </p>

                        <div class="row row-10">
                            <div class="col-sm-12">
                                <p class="form-row form-row-wide">
                                    <input type="text" class="input-text berat" placeholder="Berat" name="berat"
                                        id="Berat">
                                </p>
                            </div>
                        </div>

                        <p>
                            <a href="#" name="calc_shipping"
                                class="btn btn-lg btn-stroke mt-10 mb-mdm-40 update-total" style="padding: 20px 40px">
                                Update Totals
                            </a>
                        </p>
                    </div> <!-- end col shipping calculator -->

                    <div class="col-md-6">
                        <div class="cart_totals">
                            <h2 class="heading relative bottom-line full-grey uppercase mb-30">Cart Totals</h2>

                            <table class="table shop_table">
                                <tbody>
                                    <tr class="cart-subtotal">
                                        <th>Cart Subtotal</th>
                                        {{-- <td>
                                            <span class="amount cart-total">{{ $cart_total }}</span>
                                        </td> --}}
                                    </tr>
                                    <tr class="shipping">
                                        <th>Shipping</th>
                                        <td>
                                            <span class="shipping-cost">0</span>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Order Total</th>
                                        <td>
                                            <input type="hidden" name="cart_total" class="cart_total">
                                            <strong><span class="amount cart-total">{{ $cart_total }}</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div> <!-- end col cart totals -->

                </div> <!-- end row -->
            </form>

        </div> <!-- end container -->
    </section> <!-- end cart -->

@endsection

@push('js')
    <script>
        $(function() {
            $('.checkout').click(function(e) {
                e.preventDefault();
                var grandtotal = parseInt($('.cart-total').text());

                // Menambahkan data tambahan ke dalam objek data
                var formData = $('.form-cart').serializeArray();
                formData.push({
                    name: 'cart_total',
                    value: grandtotal
                });
                $.ajax({
                    url: '/checkout_orders',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    success: function() {
                        location.href = '/orders';
                    }
                });
            });
        });
    </script>
@endpush
