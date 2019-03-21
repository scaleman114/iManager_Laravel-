@extends('zohocontacts.layout')

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
            <a href="{{ url('/zohocontacts') }}" class="btn btn-success">Refresh from Zoho</a>
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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>

                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{$contact->contact_id}}</td>
                <td>{{$contact->customer_name}}</td>
                <td>{{$contact->customer_email}}</td>
                <td>{{$contact->customer_phone}}</td>



                <td><a href="{{ route('zohocontacts.edit',$contact->contact_id)}}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <form action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')"
                            type="submit">Delete</button>
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