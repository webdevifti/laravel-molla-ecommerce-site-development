@extends('admin.master')
@section('page_title','Admin | Coupon Code')
@section('MainContent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Coupons Code</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.coupon.store') }}" method="POST">
                            @csrf
                            <div class="mt-3">
                                <label for="">Coupon Title</label>
                                <input type="text" name="coupon_name" class="form-control" placeholder="Enter Coupon title">
                                @error('coupon_name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="">Coupon Value</label>
                                <input type="text" name="coupon_value" class="form-control" placeholder="Enter Coupon value">
                                @error('coupon_value')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="">Coupon Expire Date</label>
                                <input type="date" name="coupon_expire" class="form-control"">
                                @error('coupon_expire')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-info">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Colors</h3>
                    </div>
                    <div class="card-body">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Coupon Name</th>
                                    <th>Coupon Value</th>
                                    <th>Coupon Expire</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Coupon Name</th>
                                    <th>Coupon Value</th>
                                    <th>Coupon Expire</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php
                                    $sl = 0;
                                @endphp
                                @foreach($coupons as $coupon)
                                @php
                                    $sl++
                                @endphp
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $coupon->coupon_name }}</td>
                                    <td>{{ $coupon->coupon_value }}</td>
                                    <td>{{ $coupon->coupon_expire }}</td>
                                    <td>{{ $coupon->created_at->diffForHumans() }}</td>
                                    <td>{{ $coupon->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if($coupon->status == 1)
                                            <a href="{{ route('admin.coupon.status',$coupon->id) }}" class="btn btn-success btn-sm">Active</a>
                                        @else 
                                            <a href="{{ route('admin.coupon.status',$coupon->id) }}" class="btn btn-secondary btn-sm">Inactive</a>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('admin.coupon.edit',$coupon->id) }}" class="btn btn-info btn-sm">Edit</a> --}}

                                        <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="/admin/coupon/delete/{{ $coupon->id }}">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('FooterScript')
@if(session('success'))
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '{{ session('success') }}'
    })
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: '{{ session('error') }}',
    })
</script>
@endif
@endsection