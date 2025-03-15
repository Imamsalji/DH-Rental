@extends('layouts.app')
@section('title', 'Riwayat')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Riwayat Booking</h4>
        </div>
        <div class="card-content">
            <!-- table striped -->
            <div class="table-responsive datatable-minimal">
                <table class="table" id="table2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rental</th>
                            <th>harga per sesi</th>
                            <th>sewa per sesi</th>
                            <th>total rental</th>
                            <th>Tanggal Booking</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rental as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-bold-500">{{ $item->console->name }}</td>
                                <td>{{ $item->console->price }}</td>
                                <td>{{ $item->sesi }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->booking_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- sweetalert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
@endsection
