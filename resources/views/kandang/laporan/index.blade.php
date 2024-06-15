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
                <h1>{{ Auth::user()->name }}</h1>
            </div>
        </div>
        <div class="row mt-2">
            <form action="{{ route('laporkan-kandang.index') }}" method="GET">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group
                        ">
                            <label for="date">Bulan</label>
                            <select name="date" id="date" class="form-control">
                                <option value="">Pilih Bulan</option>
                                @foreach ($date as $item)
                                    <option value="{{ $item['date'] }}" {{ request()->get('date') == $item['date'] ? 'selected' : '' }}>{{ $item['date'] }}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('laporkan-kandang.index') }}" class="btn btn-danger">Reset</a>
                    </div>


                </div>
            </form>
        </div>


        <table class="table">
            <thead>
                <tr>
                    <th>Nama Bulan</th>
                    <th>Total Pengeluaran</th>
                    <th>Total Pemasukan</th>
                    <th>Keuntungan</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)

                    <tr>
                        <td>{{ $item['bulan'] }}</td>
                        <td>Rp. {{ number_format($item['pengeluaran']) }}</td>
                        <td>Rp. {{ number_format($item['pemasukan']) }}</td>
                        <td>Rp. {{ number_format($item['keuntungan']) }}</td>
                        <td>
                            <a href="{{ route('laporkan-kandang.show', $item['bulan']) }}" class="btn btn-info" title="Detail Laporan" ><i class="bi bi-eye"></i></a>
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
   
    
</div>

@endsection