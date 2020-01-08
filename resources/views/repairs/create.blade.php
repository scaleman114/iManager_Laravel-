@extends('repairs.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}
</style>
<div class="card uper">
    <div class="card-header">
        Add Repair
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



        <form method="post" action="{{ route('repairs.store') }}">

            <div class="form-group">
                @csrf
                <label for="zcontact">Contact :</label>
                <select class="form-control" name="repair_customer">
                    @foreach($zohocontacts as $zcontact)
                    <option value="{{$zcontact->customer_name}}">{{$zcontact->customer_name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="date">Date :</label>
                <div class="input-group datepick">
                    <input class="form-control" type="text" id="datepicker" name="date" maxlength="10">

                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="Quoted">Quoted :</label>
                <input type="number" min="0.01" step="0.01" class="form-control" name="quoted" />
            </div>

            <div class="form-group">
                <label for="min_charge">Minimum Charge :</label>
                <input type="number" min="0.01" step="0.01" class="form-control" name="min_charge" />
            </div>

            <div class="form-group">
                <label for="period">Hours :</label>
                <input type="number" min="0.5" step="0.25" class="form-control" name="hours" />
            </div>

            <div class="form-group">
                <label for="type">Repair Type :</label>
                <select class="form-control" name="repair_type" />
                <option value=0>{{ \App\Enums\RepairType::getDescription(0) }}</option>
                <option value=1>
                    {{ \App\Enums\RepairType::getDescription(1) }}</option>
                <option value=2>{{ \App\Enums\RepairType::getDescription(2) }}</option>
                <option value=3>{{ \App\Enums\RepairType::getDescription(3) }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="notes">Work Carried Out :</label>
                <textarea class="form-control" name="notes" placeholder="Notes" /></textarea>
            </div>




            <div class="form-row">
                <div class="col-md-6"> <button type="submit" class="btn btn-primary">Add</button>
                    <a href="{{route('repairs.index')}}" class="btn btn-secondary">Cancel</a>
                </div>

            </div>
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