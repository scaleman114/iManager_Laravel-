@extends('contacts.layout')

@section('content')
<style>
    .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
    <div class="card-header">
        Add contact
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
        <form method="post" action="{{ route('contacts.store') }}">
            <div class="form-group">
                @csrf
                <label for="contact_name">Name :</label>
                <input type="text" class="form-control" name="contact_name">
            </div>

            <div class="form-group">
                <label for="job_title">Job Title :</label>
                <input type="text" class="form-control" name="job_title" placeholder="Job title">
            </div>

            <div class="form-group">
                <label for="phone">Main Phone :</label>
                <input type="text" class="form-control" name="phone" placeholder="Phone">
            </div>

            <div class="form-group">
                <label for="ext">Extension :</label>
                <input type="text" class="form-control" name="ext" placeholder="Phone extension">
            </div>

            <div class="form-group">
                <label for="mobile">Mobile :</label>
                <input type="text" class="form-control" name="mobile" placeholder="Mobile phone">
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="text" class="form-control" name="email" placeholder="email">
            </div>

            <div class="form-group">
                <label for="customer_id">Customer Id :</label>
                <input type="text" class="form-control" name="customer_id" value={{$customer_id}}>
            </div>


            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection