@extends('groups.layout')

@section('content')
<style>
    .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
    <div class="card-header">
        Add Group
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
        <form method="post" action="{{ route('groups.store') }}">
            <div class="form-group">
                @csrf
                <label for="name">Name :</label>
                <input type="text" class="form-control" name="name">
            </div>


            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection