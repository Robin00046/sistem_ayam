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
                <h1>Daftar Kandang</h1>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->alamat }}</td>
                        <td>
                            @if ($customer->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('detail-kandang.show', $customer->id) }}" class="btn btn-info" title="Detail Kandang" ><i class="bi bi-eye"></i></a>
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
              <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group
                  ">
                      <label for="name">name</label>
                      <input type="text" class="form-control" id="name" name="name">

                      @error('name')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="form-group">
                      <label for="phone">phone</label>
                      <input type="text" class="form-control" id="phone" name="phone">

                      @error('phone')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="form-group">
                      <label for="email">email</label>
                      <input type="email" class="form-control" id="email" name="email">

                      @error('email')
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