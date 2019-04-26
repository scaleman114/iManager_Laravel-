@extends('contracts.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}
</style>
<div class="card uper">
    <div class="card-header">
        Edit Contract
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
        <form method="post" action="{{ route('contracts.update', $contract->id) }}">
            @method('PATCH')
            @csrf

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="id">Contract Id :</label>
                    <input class="form-control" type="text" name="contract_id" value="{{ $contract->contract_id }}">
                </div>
                <div class="form-group col-md-9">
                    <label for="zcontact">Customer :</label>
                    <select class="form-control" name="contract_customer">
                        @foreach($zohocontacts as $zcontact)
                        <option value="{{$zcontact->customer_name}}" @if ($zcontact->
                            customer_name==$contract->contract_customer)
                            selected="selected" @endif>{{ $zcontact->customer_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="startdate">Commence :</label>
                    <div class="input-group datepick">
                        <input class="form-control" type="text" id="datepicker" name="contract_startdate"
                            value="{{ $contract->contract_startdate }}" maxlength="10">

                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>


                <div class="form-group col-md-6">
                    <label for="terms">Terms :</label>
                    <input class="form-control" type="text" name="contract_terms"
                        value="{{ $contract->contract_terms }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="premium">Contract Premium :</label>
                    <input class="form-control" type="number" min="0.01" step="0.01" name="contract_premium"
                        value="{{ $contract->contract_premium }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="period">Contract Period :</label>
                    <input type="number" min="1" max="48" class="form-control" name="contract_period"
                        value="{{ $contract->contract_period }}" />
                </div>



                <div class="form-group col-md-4">
                    <label for="type">Contract Type :</label>
                    <select class="form-control" name="contract_type" placeholder="Type"
                        value="{{ $contract->contract_type }}" />
                    <option value=0 @if ($contract->contract_type==0)
                        selected="selected" @endif>{{ \App\Enums\ContractType::getDescription(0) }}</option>
                    <option value=1 @if ($contract->contract_type==1)
                        selected="selected" @endif>
                        {{ \App\Enums\ContractType::getDescription(1) }}</option>
                    <option value=2 @if ($contract->contract_type==2)
                        selected="selected" @endif>{{ \App\Enums\ContractType::getDescription(2) }}</option>
                    <option value=3 @if ($contract->contract_type==3)
                        selected="selected" @endif>{{ \App\Enums\ContractType::getDescription(3) }}</option>
                    </select>
                </div>

            </div>

            <div class="form-group">
                <label for="notes">Contract Notes :</label>
                <textarea class="form-control" name="contract_notes" placeholder="Notes"
                    value="{{ $contract->contract_notes }}"></textarea>
            </div>

            <div class="form-row">
                <div class="col-md-6"> <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route('contracts.index')}}" class="btn btn-secondary">Cancel</a>
                </div>
                <div class="col-md-6">

                    <a href="{{ route('contractitems.create',$contract->id)}}" class="btn btn-success">Add New</a>

                </div>
            </div>
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Machine</td>
                    <td>Serial No.</td>
                    <td>Capacity</td>

                    <td>Updated</td>

                    <td colspan="3">Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($contractitems as $items)
                <tr>
                    <td>{{$items->id}}</td>
                    <td>{{$items->mc_type}}</td>
                    <td>{{$items->serial_no}}</td>
                    <td>{{$items->capacity}}</td>


                    <td>{{ date('d/m/y', strtotime($items->updated_at)) }}</td>





                </tr>
                @endforeach
            </tbody>
        </table>
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
