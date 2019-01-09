@extends('customers.layout')

@section('content')
<style>
    .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
    <div class="card-header">
        Edit Customer
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
        <form method="post" action="{{ route('customers.update', $customer->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="cust_name" size="30" value="{{ $customer->cust_name }}" />
            </div>

            <div class="form-group">
                <label for="address">Address :</label>
                <textarea class="form-control" name="address">{{ $customer->address }} </textarea>
            </div>


            <div class="form-group">
                <label for="mainphone">Main Phone:</label>
                <input type="text" class="form-control" name="main_phone" size="30" value="{{ $customer->main_phone }}" />
            </div>

            <div class="form-group">
                <label for="mainemail">Main Email:</label>
                <input type="text" class="form-control" name="main_email" size="30" value="{{ $customer->main_email }}" />
            </div>

            <div class="form-group">
                <label for="vatno">Vat No:</label>
                <input type="text" class="form-control" name="vatno" size="30" value="{{ $customer->vatno }}" />
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{route('customers.index')}}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<div class="uper">
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <div>
        <div class="col-md-12">
            <a href="{{ route('contacts.create',$customer->id) }}" class="btn btn-success">Add Contact</a>
        </div>
    </div>
    <table class="table table-hover table-striped">

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


</div>

@endsection