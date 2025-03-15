@extends('layouts.app')
@section('title', 'Pembayaran VA')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Lakukan Pembayaran</h4>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <center>
            <div class="card-content ">
                <div id="snap-container"></div>
            </div>
        </center>

    </div>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-752jD5eG4VdncvPj"></script>
    <script type="text/javascript">
        window.snap.embed('{{ $token }}', {
            embedId: 'snap-container'
        });
    </script>
@endsection
