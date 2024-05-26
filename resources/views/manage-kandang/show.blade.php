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
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah Pengeluaran
                  </button>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total Pengeluaran</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengeluaran as $item)

                    <tr>
                        <td>{{ $item->jenisProduk->nama }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp. {{ number_format($item->jenisProduk->harga) }}</td>
                        <td>Rp. {{ number_format($item->total) }}</td>
                        <td>
                            <button title="Edit Data" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button title="Hapus Data" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                            
                              <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Edit Produk</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{ route('tambah-pengeluaran.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                          @csrf
                                          @method('PUT')
                                          <input type="hidden" name="kandang_id" value="{{ $user->id }}">
                  <div class="form-group">
                      <label for="jenis_produt_id">Jenis Produk</label>
                        <select class="form-control" id="jenis_produk_id" name="jenis_produk_id">
                            @foreach ($jenisProduks as $product)
                                @if ($product->id == $item->jenisProduk->id)
                                    <option value="{{ $product->id }}" selected>{{ $product->nama }}</option>
                                @else
                                    <option value="{{ $product->id }}">{{ $product->nama }}</option>
                                @endif

                            @endforeach
                        </select>
                        @error('jenis_produt_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  <div class="form-group
                  ">
                      <label for="jumlah">Jumlah</label>
                      <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ $item->jumlah }}">

                      @error('jumlah')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
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
                            
                            <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Delete Produk</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{ route('tambah-pengeluaran.destroy', $item->id) }}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <p>Apakah anda yakin ingin menghapus produk ini?</p>
                                          
                                          
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                          <button type="submit" class="btn btn-primary">Ya</button>
                                      </div>
                                  </form>
                                  </div>
                                </div>
                            </div>
                        </td>
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