@extends('layouts.app')
@section('title', 'Booking')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">isi data reservasi</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('payment', ['id' => $console->id]) }}" method="post">
                @csrf
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible show fade">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <p>note : 1 Sesi = 1 jam <br> Berapa sesi yang ingin Anda sewa?</p>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <input type="number" id="sesi" name="sesi" class="form-control mb-3 "
                            placeholder="Masukan Sesi....">
                    </div>
                    <div class="col-12 col-lg-1">
                        <input type="text" value="Rp." class="form-control mb-3 " disabled>
                    </div>
                    <div class="col-12 col-lg-5">
                        <input type="number" id="total" name="total" class="form-control mb-3 " disabled>
                    </div>
                </div>

                <p>Nomor Handphone</p>
                <div class="col-12 col-lg-6">
                    <input type="text" name="phone" class="form-control mb-3 " placeholder="Masukan No HP....">
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <p>Tanggal & Waktu Booking
                        </p>
                        <input type="date" name="tgl_booking" id="tgl_booking" class="form-control flatpickr-always-open"
                            placeholder="Pilih Tanggal..">
                    </div>

                    <div class="col-12 col-lg-6">
                        <p><br></p>
                        <input type="date" name="waktu_booking" class="form-control flatpickr-time-picker-24h"
                            placeholder="Pilih Waktu..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <p>Total Seluruh
                        </p>
                        <input type="text" id="total-seluruh" name="total-seluruh" class="form-control mb-3 " disabled>
                    </div>
                </div>

                {{-- <p>Pembayaran</p>
                <select name="transaksi" id="transaksi" class="form-control mb-3">
                    <option value="">-- pilih pembayaran-- </option>
                    <option value="VA">Virtual Account </option>
                    <option value="wallet">E-Wallet </option>
                </select>
                <div id="VAPg" class="row align-items-center gap-3 d-none">
                    <!-- pilih bank -->
                    <div id="group-select-bank" class="col-md mb-3 ">
                        <select class="form-select" name="thisBank" id="thisBank">
                            <option value="">Pilih Bank...</option>
                            <option value="BCA">VA BCA </option>
                            <option value="PERMATA">VA Permata </option>
                            <option value="MANDIRI">VA Mandiri </option>
                            <option value="BNI">VA BNI </option>
                            <option value="BRI">VA BRI </option>
                        </select>
                    </div>
                    <!-- /pilih bank -->
                </div>
                <div id="wallet" class="row align-items-center gap-3 d-none">
                    <!-- pilih bank -->
                    <div id="group-select-bank" class="col-md mb-3 ">
                        <select class="form-select" name="thisBank" id="thisBank">
                            <option value="">Pilih Wallet...</option>
                            <option value="shopeepay">Shopeepay </option>
                            <option value="qris">Qris </option>
                        </select>
                    </div>
                    <!-- /pilih bank -->
                </div> --}}

                <button type="submit" class="btn btn-primary me-1">Submit</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/date-picker.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let totalSeluruh = 0;
            $("#sesi").on("keyup", function() {
                let sesi = $(this).val();
                console.log(sesi);
                totalSeluruh = sesi * {{ $console->price }};
                let revers = totalSeluruh.toString().split('').reverse().join('');
                totalPembelians = revers.match(/\d{1,3}/g);
                totalPembelians = totalPembelians.join('.').split('').reverse().join('');
                $("#total").val(totalPembelians)
            });

            $("#tgl_booking").on("change", function() {
                let tgl_booking = $(this).val(); // Ambil nilai dari input date
                let date = new Date(tgl_booking);
                let day = date.getDay(); // 0 = Minggu, 6 = Sabtu

                let base_price = totalSeluruh; // Harga dasar

                let extra_charge = (day === 0 || day === 6) ? 50000 : 0; // Tambahan jika Sabtu/Minggu
                let total_price = base_price + extra_charge;
                console.log(total_price);

                $("#total-seluruh").val(total_price); // Update harga
            });
        });
    </script>
@endsection
