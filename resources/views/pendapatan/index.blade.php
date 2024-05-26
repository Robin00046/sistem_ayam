@extends('nice_admin.main')

@section('content')
<div class="container-fluid">
    <main id="main" class="main">
        
    <div class="container">
        <div class="card top-Create overflow-auto">
  
            <div class="card-body pb-0">
                @if (session()->has('success'))
                <div class="mt-2 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success')}}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
        <div class="row mt-2">
            <div class="col-md-6">
                <h1>Daftar Panen</h1>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah Produk
                  </button>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal Panen</th>
                    <th>Jumlah Kg</th>
                    <th>Harga Jual</th>
                    <th>Total Pendapatan</th>
                    {{-- <th>Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($pendapatans as $customer)
                    <tr>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->jumlah }}</td>
                        <td>{{ $customer->harga }}</td>
                        <td>
                            {{ number_format($customer->jumlah * $customer->harga) }}    
                        </td> 
                    </tr>
                @endforeach
            </tbody>
        </table>

        
            </div><!-- End Basic Modal-->

          </div>
    </div>
          </div>
    </div>
    </main>
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Produk</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('pendapatan.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                      <label for="jumlah">Jumlah</label>
                      <input type="text" class="form-control" id="jumlah" name="jumlah">

                      @error('jumlah')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
          </form>
          </div>
        </div>
    </div>
    
</div>

@endsection