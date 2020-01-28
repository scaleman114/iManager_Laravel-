@extends('contractitems.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}
</style>
<div class="card uper">
    <div class="card-header">
        Add Item: {{ $contract->contract_customer }}
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
            <div class="form-group">
                <label for="type">Cover Type :</label>
                <select class="form-control" name="contract_type" />
                <option value=0>{{ \App\Enums\ContractVisitType::getDescription(0) }}</option>
                <option value=1>{{ \App\Enums\ContractVisitType::getDescription(1) }}</option>
                <option value=2>{{ \App\Enums\ContractVisitType::getDescription(2) }}</option>
                <option value=3>{{ \App\Enums\ContractVisitType::getDescription(3) }}</option>
                <option value=4>{{ \App\Enums\ContractVisitType::getDescription(4) }}</option>
                <option value=5>{{ \App\Enums\ContractVisitType::getDescription(5) }}</option>
                <option value=6>{{ \App\Enums\ContractVisitType::getDescription(6) }}</option>
                <option value=7>{{ \App\Enums\ContractVisitType::getDescription(7) }}</option>
                <option value=8>{{ \App\Enums\ContractVisitType::getDescription(8) }}</option>
                </select>
            </div>
            



            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection