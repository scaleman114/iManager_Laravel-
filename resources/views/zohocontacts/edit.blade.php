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

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="customer_name" size="30"
                        value="{{ $contact->customer_name }}">
                </div>
                <div class="form-group col-md-5">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" size="50"
                        value="{{ $contact->customer_email }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" name="phone" size="30"
                        value="{{ $contact->customer_phone }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first">Primary Contact First Name:</label>
                    <input type="text" class="form-control" name="first" size="20" value="{{ $contact->first_name }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="last">Primary Contact Last Name:</label>
                    <input type="text" class="form-control" name="last" size="30" value="{{ $contact->last_name }}">
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address" size="100" value="{{ $contact->address }}">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="address">Street2:</label>
                    <input type="text" class="form-control" name="street2" size="80" value="{{ $contact->street2 }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" name="city" size="25" value="{{ $contact->city }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="state">County:</label>
                    <input type="text" class="form-control" name="state" size="25" value="{{ $contact->state }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="zip">Postcode:</label>
                    <input type="text" class="form-control" name="zip" size="12" value="{{ $contact->zip }}">
                </div>
            </div>




            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ '/contacts' }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection