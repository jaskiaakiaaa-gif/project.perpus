@extends('layouts.app') 

@section('content')
<div class="container-fluid">
    
    <div class="d-sm-align-items-center justify-content-between mb-4">
       
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biodata Pengguna</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <span class="btn btn-primary btn-circle btn-lg" style="width: 80px; height: 80px; font-size: 32px; line-height: 80px; border-radius: 50%;">
                            {{ strtoupper(substr($data->name, 0, 1)) }}
                        </span>
                    </div>
                    
                    <h4 class="text-gray-900 fw-bold">{{ $data->name }}</h4>
                    <p class="text-muted">{{ $data->email }}</p>
                    <hr>
                    
                    <div class="mt-4">
                        <a href="/kategori" class="btn btn-secondary btn-sm">Kembali ke Kategori</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection