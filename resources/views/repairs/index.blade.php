@extends('repairs.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}

.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.links>a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}
</style>


<div class="top-right links">

    <a href="{{ url('/') }}">Home</a>

</div>



<div class="row">
    <div>
        <div class="col-md-3">
            <a href="{{ url('/repairs/create') }}" class="btn btn-success">Add New</a>
        </div>
    </div>
    <div class="col-md-3">
        <form method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="text" class="form-control" name="searchTerm" placeholder="Search for..."
                    value="{{ isset($searchTerm) ? $searchTerm : '' }}">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit">Search</button>
                </span>
            </div>
        </form>
    </div>
</div>



<div class="uper">
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <td>Repair Id</td>
                <td>Customer</td>
                <td>Date</td>

                <td>Updated</td>

                <td colspan="3">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($repairs as $repair)
            <tr>
                <td>{{$repair->id}}</td>
                <td>{{$repair->repair_customer}}</td>
                <td>{{ date('d/m/y', strtotime($repair->date)) }}</td>

                <td>{{ date('d/m/y', strtotime($repair->updated_at)) }}</td>


                <td><a href="{{ route('repairs.edit',$repair->id)}}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{ route('repairs.destroy', $repair->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
                <td><a href="{{action('RepairController@downloadPDF', $repair->id)}}"
                        class="btn btn-info btn-sm">PDF</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>







    @endsection