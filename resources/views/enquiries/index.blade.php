@extends('enquiries.layout')

@section('content')
<style>
.uper {
    margin-top: 40px;
}

.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.links>a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}
</style>


<div class="top-right links">

    <a href="{{ url('/') }}">Home</a>

</div>



<div class="row">
    <div>
        <div class="col-md-3">
            <a href="{{ url('/enquiries/create') }}" class="btn btn-success">Add New</a>
        </div>
    </div>
    <div class="col-md-3">
        <form method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="text" class="form-control" name="searchTerm" placeholder="Search for..."
                    value="{{ isset($searchTerm) ? $searchTerm : '' }}">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit">Search</button>
                </span>
            </div>
        </form>
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
                <td>ID</td>
                <td>Customer</td>
                <td>Contact Email</td>
                <td>Enquiry Description</td>
                <td>Completed</td>
                <td>Updated</td>
                <td>Diary Date</td>
                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($enquiries as $enquiry)
            <tr>
                <td>{{$enquiry->id}}</td>
                <td>{{$enquiry->enq_customer}}</td>
                <td>{{$enquiry->enq_email}}</td>
                <td>{{$enquiry->enq_description}}</td>
                <td>{{$enquiry->enq_completed}}</td>
                <td>{{ date('d/m/y', strtotime($enquiry->updated_at)) }}</td>
                <td>{{ date('d/m/y', strtotime($enquiry->enq_diarydate)) }}</td>

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

    <div class="row">



        <div class="col-md-6">
            <form class="form-inline" method="GET" action="{{ route('enquiries.diary') }}">
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

        <div class="col-md-3">
            <form method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="hidden" name="isCleared" value="0">
                    <input type="checkbox" name="isCleared[]" value="1"> Show cleared
                    <button class="btn btn-secondary" type="submit">Go</button>

                </div>
            </form>
        </div>

    </div>






    @endsection