@extends('groups.layout')

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
    


<div>
    <div class="col-md-12">
        <a href="{{ url('/zohogroups') }}" class="btn btn-success">Refresh from Zoho</a>
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
                <td>Name</td>


                
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{$group->group_id}}</td>
                <td>{{$group->name}}</td>



                
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
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
</div>

<script>
$(".delete").on("submit", function() {
    return confirm("Are you sure?");
});
</script>






@endsection