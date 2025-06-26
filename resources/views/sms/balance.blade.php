@extends('layouts.app')

@section('content')
    @include('partials.sidebar')
    <div class="container mt-4">
        <h3>SMS Unit Balance</h3>
        <div class="row mt-2">
            <div class="col-lg-3 col-md-3 col-12 border-radius-sm">
                <div class="card border-0 border-radius-sm">
                    <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow d-flex justify-content-center text-center border-radius-2xl">
                                    <i class="fa fa-database text-dark text-gradient text-lg opacity-10 lh-base"
                                        aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    {{ $balance->total_units }}
                                </h5>
                                <span class="text-white text-sm">Total SMS Units</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12 border-radius-sm">
                <div class="card border-0 border-radius-sm">
                    <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-inbox lh-base text-dark text-gradient text-lg opacity-10"
                                        aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    {{ $balance->available_units }}
                                </h5>
                                <span class="text-white text-sm">Available SMS Units</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12 border-radius-sm">
                <div class="card border-0 border-radius-sm">
                    <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-share-square lh-base text-dark text-gradient text-lg opacity-10"
                                        aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    {{ $balance->total_units - $balance->available_units }}
                                </h5>
                                <span class="text-white text-sm">Assigned to Customers</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection