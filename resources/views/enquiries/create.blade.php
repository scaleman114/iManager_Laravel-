@extends('enquiries.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}
</style>
<div class="card uper">
    <div class="card-header">
        Add Enquiry
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
        <form method="post" action="{{ route('enquiries.store') }}">
            <div class="form-group">
                @csrf
                <label for="zcontact">Contact :</label>
                <select class="form-control" name="enq_zcontact">
                    @foreach($zohocontacts as $zcontact)
                    <option value="{{$zcontact->customer_name}}">{{$zcontact->customer_name}}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" name="enq_description" placeholder="Description"></textarea>
            </div>

            <div class="form-group">
                <label for="diarydate">Diary Date :</label>
                <div class="input-group datepick">
                    <input class="form-control" type="text" id="datepicker" name="enq_diarydate" maxlength="10">

                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{route('enquiries.index')}}" class="btn btn-secondary">Cancel</a>
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