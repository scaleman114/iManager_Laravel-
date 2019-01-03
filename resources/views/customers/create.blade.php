@extends('customers.layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Add Customer
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
      <form method="post" action="{{ route('customers.store') }}">
          <div class="form-group">
              @csrf
              <label for="cust_name">Name :</label>
              <input type="text" class="form-control" name="cust_name"/>
          </div>

          <div class="form-group">
              <label for="address">Address :</label>
              <textarea class="form-control" name="address" placeholder="Customer address"></textarea>
          </div>
          
          <div class="form-group">
              <label for="main_phone">Main Phone :</label>
              <input type="text" class="form-control" name="main_phone" placeholder="Main phone">
          </div>

          <div class="form-group">
              <label for="main_email">Main Email :</label>
              <input type="text" class="form-control" name="main_email" placeholder="Main email">
          </div>

          <div class="form-group">
              <label for="vatno">Vat No. :</label>
              <input type="text" class="form-control" name="vatno" placeholder="Vat number">
          </div>
         
          <button type="submit" class="btn btn-primary">Add</button>
          <a href="{{route('customers.index')}}" class="btn btn-secondary">Cancel</a>
      </form>
  </div>
</div>

@endsection