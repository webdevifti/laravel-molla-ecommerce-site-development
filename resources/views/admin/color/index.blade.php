@extends('admin.master')
@section('page_title','Admin | Sub Category Category')
@section('MainContent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Colors</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.color.store') }}" method="POST">
                            @csrf
                           
                            <div class="mt-3">
                                <label for="">Color Name</label>
                                <input type="text" name="color_name" class="form-control" placeholder="Enter Color Name">
                                @error('color_name')
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
                                    <th>Color Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Color Name</th>
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
                                @foreach($colors as $color)
                                @php
                                    $sl++
                                @endphp
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $color->color_name }}</td>
                                    <td>{{ $color->created_at->diffForHumans() }}</td>
                                    <td>{{ $color->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if($color->status == 1)
                                            <a href="{{ route('admin.color.status',$color->id) }}" class="btn btn-success btn-sm">Active</a>
                                        @else 
                                            <a href="{{ route('admin.color.status',$color->id) }}" class="btn btn-secondary btn-sm">Inactive</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.color.edit',$color->id) }}" class="btn btn-info btn-sm">Edit</a>

                                        <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="/admin/color/delete/{{ $color->id }}">Delete</a>
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