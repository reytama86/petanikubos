<!-- resources/views/postings/index.blade.php -->

@extends('layout.app')

@section('title', 'Data Panen')

@section('content')
    <div class="container">
        <h1>Data Panen</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanaman</th>
                    <th>Luas Tanah</th>
                    <th>Deskripsi Hasil Panen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($postings as $index => $posting)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $posting->tanaman }}</td>
                        <td>{{ $posting->luas_tanah }}</td>
                        <td>{{ $posting->deskripsi_hasil_panen }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
