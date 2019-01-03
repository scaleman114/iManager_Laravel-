@extends('customers.layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Edit Enquiry
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
          <input type="text" class="form-control" name="cust_name" size="30" value="{{ $customer->cust_name }}"/>
        </div>

        <div class="form-group">
          <label for="address">Address :</label>
          <textarea class="form-control" name="address">{{ $customer->address }} </textarea>
        </div>
        
        
        <div class="form-group">
          <label for="mainphone">Main Phone:</label>
          <input type="text" class="form-control" name="main_phone" size="30" value="{{ $customer->main_phone }}"/>
        </div>

        <div class="form-group">
          <label for="mainemail">Main Email:</label>
          <input type="text" class="form-control" name="main_email" size="30" value="{{ $customer->main_email }}"/>
        </div>
        
        <div class="form-group">
          <label for="vatno">Vat No:</label>
          <input type="text" class="form-control" name="vatno" size="30" value="{{ $customer->vatno }}"/>
        </div>
        
        
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{route('customers.index')}}" class="btn btn-secondary">Cancel</a>
      </form>
  </div>
</div>

@endsection