@extends('contacts.layout')

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
        <form method="post" action="{{ route('contacts.update', $contact->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="contact_name" size="30" value="{{ $contact->contact_name }}">
            </div>

            <div class="form-group">
                <label for="job_title">Job Title :</label>
                <input type="text" class="form-control" name="job_title" value="{{ $contact->job_title }}">
            </div>


            <div class="
                    form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" name="phone" size="30" value="{{ $contact->phone }}">
            </div>

            <div class="form-group">
                <label for="ext">Extension:</label>
                <input type="text" class="form-control" name="ext" size="10" value="{{ $contact->ext }}">
            </div>

            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="text" class="form-control" name="mobile" size="30" value="{{ $contact->mobile }}">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" size="30" value="{{ $contact->email }}">
            </div>




            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection