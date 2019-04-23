@extends('contracts.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}
</style>
<div class="card uper">
    <div class="card-header">
        Add Contract
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



        <form method="post" action="{{ route('contracts.store') }}">

            <div class="form-group">
                <label for="id">Contract Id :</label>
                <input type="text" class="form-control" name="contract_id" />
            </div>
            <div class="form-group">
                @csrf
                <label for="zcontact">Contact :</label>
                <select class="form-control" name="contract_customer">
                    @foreach($zohocontacts as $zcontact)
                    <option value="{{$zcontact->customer_name}}">{{$zcontact->customer_name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="startdate">Start Date :</label>
                <div class="input-group datepick">
                    <input class="form-control" type="text" id="datepicker" name="contract_startdate" maxlength="10">

                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="terms">Terms :</label>
                <textarea class="form-control" name="contract_terms" placeholder="Terms"></textarea>
            </div>

            <div class="form-group">
                <label for="premium">Contract Premium :</label>
                <input type="number" min="0.01" step="0.01" class="form-control" name="contract_premium" />
            </div>

            <div class="form-group">
                <label for="period">Contract Period :</label>
                <input type="number" min="1" max="48" class="form-control" name="contract_period" />
            </div>

            <div class="form-group">
                <label for="type">Contract Type :</label>
                <select class="form-control" name="contract_type" />
                <option value=0>{{ \App\Enums\ContractType::getDescription(0) }}</option>
                <option value=1>
                    {{ \App\Enums\ContractType::getDescription(1) }}</option>
                <option value=2>{{ \App\Enums\ContractType::getDescription(2) }}</option>
                <option value=3>{{ \App\Enums\ContractType::getDescription(3) }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="notes">Contract Notes :</label>
                <textarea class="form-control" name="contract_notes" placeholder="Notes" /></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{route('contracts.index')}}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('.datepick').datetimepicker({
        format: 'YYYY-MM-DD',
        ignoreReadonly: true
    });
});
</script>
@endsection