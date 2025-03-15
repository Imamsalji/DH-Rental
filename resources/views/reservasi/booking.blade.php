@extends('layouts.app')
@section('title', 'Booking')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Data Booking</h4>
            <p>note: data di bawah adalah data yang sudah melakukan pembayaran</p>
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
                            <th></th>
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
                                <td>
                                    <div class="me-1 mb-1 d-inline-block">
                                        <!-- Button trigger for default modal -->
                                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#defaultSize">
                                            Transaksi
                                        </button>

                                        <!--Default size Modal -->
                                        <div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel18" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel18">Detail Transaksi</h4>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">{{ $item->console->name }}</h4>
                                                                    <p class="card-text">
                                                                        {{ $item->console->desc }}
                                                                    </p>
                                                                    <div class="form-body">
                                                                        <div class="form-group">
                                                                            <label for="feedback1" class="sr-only">Nama
                                                                            </label>
                                                                            <input type="text" id="feedback1"
                                                                                class="form-control"
                                                                                value="{{ auth()->user()->name }}" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="feedback4" class="sr-only">Tanggal
                                                                                Booking</label>
                                                                            <input type="text"
                                                                                value="{{ $item->booking_date }}"
                                                                                class="form-control" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="feedback2"
                                                                                class="sr-only">Sesi</label>
                                                                            <input type="text" id="feedback2"
                                                                                class="form-control"
                                                                                value="{{ $item->sesi }}" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="feedback2" class="sr-only">Total
                                                                                Harga</label>
                                                                            <input type="email" id="feedback2"
                                                                                class="form-control"
                                                                                value="{{ $item->price }}" disabled>
                                                                        </div>
                                                                        <div class="alert alert-success"><i
                                                                                class="bi bi-check-circle"></i> Pembayaran
                                                                            telah terkonfirmasi.</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
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
