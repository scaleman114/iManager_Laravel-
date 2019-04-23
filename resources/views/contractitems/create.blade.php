@extends('contractitems.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}
</style>
<div class="card uper">
    <div class="card-header">
        Add Contract Item: {{ $contract->contract_customer }}
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
        <form method="post" action="{{ route('contractitems.store') }}">

            <div class="form-group">
                <label for="contractid">Contract Id :</label>
                <input type="text" class="form-control" name="contract_id" value="{{ $contract->id }}" />
            </div>
            <div class="form-group">
                @csrf
                <label for="mc_type">Machine Type :</label>
                <input type="text" class="form-control" name="mc_type">
            </div>
            <div class="form-group">
                <label for="serialno">Serial No :</label>
                <input type="text" class="form-control" name="serial_no" />
            </div>
            <div class="form-group">
                <label for="capacity">Capacity :</label>
                <input type="text" class="form-control" name="capacity" />
            </div>



            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection