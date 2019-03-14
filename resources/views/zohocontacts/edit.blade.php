@extends('zohocontacts.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}
</style>
<div class="card uper">
    <div class="card-header">
        Edit Contact for {{ $contact->customer_name }}
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
        <form method="post" action="{{ route('zohocontacts.update', $contact->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="customer_name" size="30"
                    value="{{ $contact->customer_name }}">
            </div>


            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" size="30" value="{{ $contact->customer_email }}">
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address" size="100" value="{{ $contact->address }}">
            </div>

            <div class="form-group">
                <label for="address">Street2:</label>
                <input type="text" class="form-control" name="street2" size="80" value="{{ $contact->street2 }}">
            </div>

            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" class="form-control" name="city" size="25" value="{{ $contact->city }}">
            </div>

            <div class="form-group">
                <label for="zip">Postcode:</label>
                <input type="text" class="form-control" name="zip" size="12" value="{{ $contact->zip }}">
            </div>




            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ '/contacts' }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection