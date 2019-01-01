@extends('enquiries.layout')

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
      <form method="post" action="{{ route('enquiries.update', $enquiry->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">Customer:</label>
          <input type="text" class="form-control" name="enq_customer" size="30" value="{{ $enquiry->enq_customer }}"/>
        </div>

        <div class="form-group">
          <label for="contact">Contact Details:</label>
          <input type="text" class="form-control" name="enq_contact" size="30" value="{{ $enquiry->enq_contact }}"/>
        </div>
        
        <div class="form-group">
          <label for="description">Description :</label>
          <textarea class="form-control" name="enq_description">{{ $enquiry->enq_description }} </textarea>
        </div>

        <div class="form-group">
              <label for="diarydate">Diary Date :</label>
              <div class="input-group datepick">
              <input class="form-control"  type="text" id="datepicker" name="enq_diarydate" value="{{ $enquiry->enq_diarydate }}" maxlength="10">
            
              <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div> 
                </div>     
         </div>

        <div class="form-group">
          <label for="completed">Completed :</label>
          <input type="hidden" class="form-control" name="enq_completed" value="0" />
          <input type="checkbox" class="form-control" name="enq_completed[]" value="{{ $enquiry->enq_completed }}" 
          @if ($enquiry->enq_completed) checked="1" @endif />
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
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