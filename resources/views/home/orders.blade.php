@extends('layout.home')

@section('title', 'Checkout')

@section('content')

    <!-- Checkout -->
    <section class="section-wrap checkout pb-70">
        <div class="container relative">
            <div class="row">
                <h2>My Orders</h2>
                <div class="ecommerce col-xs-12">

                    <table class="table table-ordered table-hover table-striped">
                        <thead>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>Rp. {{number_format($order->total_harga)}}</td>
                                    <td>{{$order->status}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h2>My Payments</h2>
                <div class="ecommerce col-xs-12">

                    <table class="table table-ordered table-hover table-striped">
                        <thead>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nominal Transfer</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            {{-- @foreach ($payments as $index => $payment)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$payment->created_at}}</td>
                                    <td>Rp. {{number_format($payment->jumlah)}}</td>
                                    <td>{{$payment->status}}</td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>

                </div> <!-- end ecommerce -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </section> <!-- end checkout -->

@endsection

