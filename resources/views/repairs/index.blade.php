@extends('repairs.layout')

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
            <a href="{{ url('/repairs/create') }}" class="btn btn-success">Add New</a>
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
    @if (session()->get('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <td>Repair Id</td>
                <td>Customer</td>
                <td>Date</td>

                <td>Updated</td>

                <td colspan="3">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($repairs as $repair)
            <tr>
                <td>{{$repair->id}}</td>
                <td>{{$repair->repair_customer}}</td>
                <td>{{ date('d/m/y', strtotime($repair->date)) }}</td>

                <td>{{ date('d/m/y', strtotime($repair->updated_at)) }}</td>


                <td><a href="{{ route('repairs.edit',$repair->id)}}" class="btn btn-primary">Edit/View</a></td>
                <td>
                    <form action="{{ route('repairs.destroy', $repair->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
                <td><a href="{{action('RepairController@downloadPDF', $repair->id)}}"
                        class="btn btn-info btn-sm">PDF</a></td>

                {{-- Get data to populate the modal and display it using script BTW this is how you comment in a blade --}}
                   <td>
                    <button type="button" class="btn btn-primary btn-sm" id="email_btn" data-toggle="modal"
                        data-target="#EmailModal" data-repairid="{{ $repair->id }}"
              data-email="{{ $repair->email }}" >

                Email PDF
                </button>
                </td> 

               

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div>
    {{-- Pagination links --}}
    {{ $repairs->links() }}
    
</div>    




    <!-- Modal HTML Markup -->
    <div id="EmailModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title text-xs-center">Email the repair as pdf file</h4>


                </div>

                <div class="modal-body">


                    <form role="form" method="POST" action="{{ route('repair.emailpdf')}}">

                        <input type="hidden" name="_token" value="">
                        <div class="form-group">
                            @csrf
                            <label class="control-label">E-Mail Address (if empty uses zoho default Email)</label>
                            <div>
                                <input type="email" class="form-control input-lg" name="email" value="">
                            </div>

                            <div>
                                <input type="hidden" class="form-control input-lg" name="repair_id" value="">
                            </div>
                        </div>


                        <div class="form-group">
                            <div>

                                <button type="submit" class="btn btn-info btn-block">Send</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>{{-- /.modal-content --}}
        </div>{{-- /.modal-dialog --}}
    </div>{{-- /.modal --}}



    {{-- function to show the email modal --}}
    <script type="text/javascript">
    $(function() {
        $('#EmailModal').on("show.bs.modal", function(e) {
            var repairId = $(e.relatedTarget).data('repairid');
            var email = $(e.relatedTarget).data('email'); 

            //populate the email textbox
            $(e.currentTarget).find('input[name="email"]').val(email);
            //populate the textbox which is hidden
            $(e.currentTarget).find('input[name="repair_id"]').val(repairId);

        });
    });
    </script>

    @endsection