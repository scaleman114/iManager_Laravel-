@extends('repairs.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}
</style>
<div class="card uper">
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <div class="card-header">
        Edit Repair
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
        <form method="post" action="{{ route('repairs.update', $repair->id) }}">
            @method('PATCH')
            @csrf

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="id">Repair Id :</label>
                    <input class="form-control" type="text" name="repair_id" value="{{ $repair->id }}">
                </div>
                <div class="form-group col-md-9">
                    <label for="zcontact">Customer :</label>
                    <select class="form-control" name="repair_customer">
                        @foreach($zohocontacts as $zcontact)
                        <option value="{{$zcontact->customer_name}}" @if ($zcontact->
                            customer_name==$repair->repair_customer)
                            selected="selected" @endif>{{ $zcontact->customer_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="date">Repair Date :</label>
                    <div class="input-group datepick">
                        <input class="form-control" type="text" id="datepicker" name="repair_date"
                            value="{{ $repair->date }}" maxlength="10">

                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="type">Repair Type :</label>
                    <select class="form-control" name="repair_type" placeholder="Type"
                        value="{{ $repair->repair_type }}" />
                    <option value=0 @if ($repair->repair_type==0)
                        selected="selected" @endif>{{ \App\Enums\RepairType::getDescription(0) }}</option>
                    <option value=1 @if ($repair->repair_type==1)
                        selected="selected" @endif>
                        {{ \App\Enums\RepairType::getDescription(1) }}</option>
                    <option value=2 @if ($repair->repair_type==2)
                        selected="selected" @endif>{{ \App\Enums\RepairType::getDescription(2) }}</option>
                    <option value=3 @if ($repair->repair_type==3)
                        selected="selected" @endif>{{ \App\Enums\RepairType::getDescription(3) }}</option>
                    </select>
                </div>


            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="mincharge">Min. Charge :</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" type="text" name="min_charge"
                        value="{{ $repair->min_charge }}">

                </div>


                <div class="form-group col-md-4">
                    <label for="terms">Quoted :</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" type="text" name="quoted"
                        value="{{ $repair->quoted }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="terms">Hours :</label>
                    <input type="number" min="0.5" step="0.25" class="form-control" type="text" name="hours"
                        value="{{ $repair->hours }}">
                </div>
            </div>


            <div class="form-group">
                <label for="notes">Repair Notes :</label>
                <textarea class="form-control" name="repair_notes"> {{ $repair->notes }} </textarea>
            </div>

            <div class="form-row">
                <div class="col-md-6"> <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route('repairs.index')}}" class="btn btn-secondary">Cancel</a>
                </div>
                <div class="col-md-6">

                    <a href="{{ route('repairitems.create',$repair->id)}}" class="btn btn-success">Add New</a>

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

                    <td colspan="2">Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($repairitems as $items)
                <tr>
                    <td>{{$items->id}}</td>
                    <td>{{$items->mc_type}}</td>
                    <td>{{$items->serial_no}}</td>
                    <td>{{$items->capacity}}</td>


                    <td>{{ date('d/m/y', strtotime($items->updated_at)) }}</td>
                    <td><a href="{{ route('repairitems.edit',$items->id)}}" class="btn btn-primary">Edit</a></td>
                    <td>
                        <form action="{{ route('repairitems.destroy', $items->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>





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