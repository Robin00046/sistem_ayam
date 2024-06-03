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
                <h1>{{ $user->name }}</h1>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Bulan</th>
                    <th>Total Pengeluaran</th>
                    <th>Total Pemasukan</th>
                    <th>Keuntungan</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)

                    <tr>
                        <td>{{ $item['bulan'] }}</td>
                        <td>Rp. {{ number_format($item['pengeluaran']) }}</td>
                        <td>Rp. {{ number_format($item['pemasukan']) }}</td>
                        <td>Rp. {{ number_format($item['keuntungan']) }}</td>
                        
                        
                    </tr>

                    
                @empty
                    
                @endforelse
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
              <h5 class="modal-title">Tambah Pengeluaran</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('tambah-pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="kandang_id" value="{{ $user->id }}">
                  <div class="form-group">
                      <label for="jenis_produt_id">Jenis Produk</label>
                        <select class="form-control" id="jenis_produk_id" name="jenis_produk_id">
                            @foreach ($jenisProduks as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('jenis_produt_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  <div class="form-group
                  ">
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