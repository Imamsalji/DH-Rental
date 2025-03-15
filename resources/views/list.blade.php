@extends('layouts.app')
@section('title', 'List Rental')
@section('content')
    @foreach ($console as $item)
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title"> {{ $item->name }} </h4>
                        <p class="card-text">
                            {{ $item->desc }}
                        </p>
                        <h6>Harga per sesi = Rp.{{ $item->price }} </h6>
                        <div class="form-actions d-flex justify-content-end">
                            <a href="/halPayment/{{ $item->id }} " class="btn btn-primary me-1">pilih</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
