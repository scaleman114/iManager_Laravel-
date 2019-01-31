@extends('parts.layout')

@section('content')
<style>
    .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
    <div class="card-header">
        Add Part
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
        <form method="post" action="{{ route('parts.store') }}">
            <div class="form-group">
                @csrf
                <label for="description">Description :</label>
                <input type="text" class="form-control" name="description" />
            </div>

            <div class="form-group">
                <label for="group_id">Name :</label>
                <select class="form-control" name="group_id">
                    @foreach($groups as $group)
                    <option value="{{$group->id}}">{{$group->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cost">Cost :</label>
                <input type="text" class="form-control" name="cost" />
            </div>

            <div class="form-group">
                <label for="price">Price :</label>
                <input type="text" class="form-control" name="price" />
            </div>

            <div class="form-group">
                <label for="supplier_no">Supplier Part No. :</label>
                <input type="text" class="form-control" name="supplier_no" placeholder="Supplier Part No.">
            </div>

            <div class="form-group">
                <label for="stock_item">Stock Item :</label>
                <input type="checkbox" class="form-control" name="stock_item" value="0" />

            </div>

            <div class="form-group">
                <label for="count">Count :</label>
                <input type="text" class="form-control" name="count" placeholder="Stock count">
            </div>

            <div class="form-group">
                <label for="notes">Notes :</label>
                <textarea class="form-control" name="notes" placeholder="Part notes"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{route('parts.index')}}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection