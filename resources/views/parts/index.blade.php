@extends('parts.layout')

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
            <a href="{{ url('/zohoparts') }}" class="btn btn-success">Refresh from Zoho</a>
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
                <td>SKU</td>
                <td>Description</td>
                <td>Cost</td>
                <td>Price</td>
                <td>Count</td>
                <td>Supplier Part No.</td>
                <td>Notes</td>
                <td>Stock Item</td>

                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($parts as $part)
            <tr>
                <td>{{$part->part_id}}</td>
                <td>{{$part->sku}}</td>
                <td>{{$part->description}}</td>
                <td>{{$part->cost}}</td>
                <td>{{$part->price}}</td>
                <td>{{$part->count}}</td>
                <td>{{$part->supplier_no}}</td>
                <td>{{$part->notes}}</td>
                <td>{{$part->stock_item}}</td>



                <td><a href="{{ route('parts.edit',$part->id)}}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{ route('parts.destroy', $part->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')"
                            type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                <td>Count: {{count($parts)}} </td>
            </tr>
        </tbody>
    </table>

</div>

<script>
$(".delete").on("submit", function() {
    return confirm("Are you sure?");
});
</script>






@endsection