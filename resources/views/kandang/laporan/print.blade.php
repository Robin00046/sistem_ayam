<!DOCTYPE html>
<html lang="en">

@include('nice_admin.head')

<body>
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
                <div class="col-md-6">
                    <h1>Daftar Pendapatan</h1>
                </div>
            </div>
            <!-- Print window -->
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
                    @foreach ($pendapatan as $customer)
                        <tr>
                            <td>{{ $customer->created_at }}</td>
                            <td>{{ $customer->jumlah }}</td>
                            <td>Rp. {{ number_format($customer->harga) }}</td>
                            <td>
                                Rp. {{ number_format($customer->jumlah * $customer->harga) }}    
                            </td> 
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td>Rp. {{ $total_pendapatan }}</td>
                    </tr>
                </tfoot>
    
            </table>
    
            <div class="row mt-2">
                <div class="col-md-6">
                    <h1>Daftar Pengeluaran</h1>
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
                            
                        </tr>
    
                        
                    @empty
                        
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total</td>
                        <td>Rp. {{ $total_pengeluaran }}</td>
                    </tr>
                </tfoot>
            </table>
    
            <div class="row mt-2">
                <div class="col-md-6">
                    <h1>Laporan</h1>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Total Pengeluaran</th>
                        <th>Total Pemasukan</th>
                        <th>Keuntungan</th>
                        
                    </tr>
                </thead>
    
                <tbody>
                        <tr>
                            <td>Rp. {{ $data['total_pengeluaran'] }}</td>
                            <td>Rp. {{ $data['total_pendapatan'] }}</td>
                            <td>Rp. {{ $data['total_keuntungan'] }}</td>
    
                            
                        </tr>
                </tbody>
            </table>
    
    
            
    
            
                </div><!-- End Basic Modal-->
    
              </div>
        </div>
              </div>
        </div>

  
<script>
    window.print();
</script>
</body>

</html>