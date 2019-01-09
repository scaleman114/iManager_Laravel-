@extends('customers.layout')

@section('content')
<style>
    .uper {
    margin-top: 40px;
  }
</style>



<div class="row">
    <div>
        <div class="col-md-3">
            <a href="{{ url('/customers/create') }}" class="btn btn-success">Add New</a>
        </div>
    </div>
    <div class="col-md-3">
        <form method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="text" class="form-control" name="searchTerm" placeholder="Search for..." value="{{ isset($searchTerm) ? $searchTerm : '' }}">
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
                <td>ID</td>
                <td>Name</td>
                <td>Address</td>
                <td>Main Phone</td>
                <td>Main Email</td>

                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{$customer->id}}</td>
                <td>{{$customer->cust_name}}</td>
                <td>{{$customer->address}}</td>
                <td>{{$customer->main_phone}}</td>
                <td><a href="mailto:{{$customer->main_email}}">{{$customer->main_email}}</a></td>


                <td><a href="{{ route('customers.edit',$customer->id)}}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{ route('customers.destroy', $customer->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script>
    $(".delete").on("submit", function() {
        return confirm("Are you sure?");
    });
</script>






@endsection