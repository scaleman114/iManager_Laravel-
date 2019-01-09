@extends('contacts.layout')

@section('content')
<style>
    .uper {
    margin-top: 40px;
  }
</style>

<div>
    <div class="col-md-12">
        <a href="{{ url('/contacts/create') }}" class="btn btn-success">Add New</a>
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
                <td>Job Title</td>
                <td>Phone</td>
                <td>Ext</td>
                <td>Mobile</td>
                <td>Email</td>

                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{$contact->id}}</td>
                <td>{{$contact->contact_name}}</td>
                <td>{{$contact->job_title}}</td>
                <td>{{$contact->phone}}</td>
                <td>{{$contact->ext}}</td>
                <td>{{$contact->mobile}}</td>
                <td>{{$contact->email}}</td>


                <td><a href="{{ route('contacts.edit',$contact->id)}}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{ route('contacts.destroy', $contact->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
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
</div>

<script>
    $(".delete").on("submit", function() {
        return confirm("Are you sure?");
    });
</script>






@endsection