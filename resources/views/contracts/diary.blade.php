@extends('enquiries.layout')

@section('content')
<style>
    .uper {
    margin-top: 40px;
  }
</style>

<div>
    <div class="col-md-12">
        <h3 class="text-center">Alerts this {{ $datePeriod }}</h3>
        <a href="{{ url('/enquiries/create') }}" class="btn btn-success">Add New</a>
    </div>
</div>

<div class="uper">
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <td>Diary Date</td>
                <td>ID</td>
                <td>Customer</td>
                <td>Contact Details</td>
                <td>Enquiry Description</td>
                <td>Completed</td>
                <td>Updated</td>
                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($enquiries as $enquiry)

            <tr>
                <td>{{ date('d/m/y', strtotime($enquiry->enq_diarydate)) }}</td>
                <td>{{$enquiry->id}}</td>
                <td>{{$enquiry->enq_customer}}</td>
                <td>{{$enquiry->enq_contact}}</td>
                <td>{{$enquiry->enq_description}}</td>
                <td>{{$enquiry->enq_completed}}</td>
                <td>{{ date('d/m/y', strtotime($enquiry->updated_at)) }}</td>


                <td><a href="{{ route('enquiries.edit',$enquiry->id)}}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{ route('enquiries.destroy', $enquiry->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>


    <div class="col-md-2">
        <a href="{{route('enquiries.index')}}" class="btn btn-secondary">Cancel</a>
    </div>

    <div class="col-md-3">
        <form class="form-inline" method="GET" action="{{ route('enquiries.diary', $enquiry->id) }}">
            {{csrf_field()}}
            <div class="form-group">
                <select class="form-control" name="dateperiod" id="dateperiod">
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>

                <button class="btn btn-secondary" type="submit">Go</button>

            </div>
        </form>
    </div>
</div>






@endsection