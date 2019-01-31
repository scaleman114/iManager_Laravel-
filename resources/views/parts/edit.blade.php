@extends('parts.layout')

@section('content')
<style>
    .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
    <div class="card-header">
        Edit part
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
        <form method="post" action="{{ route('parts.update', $part->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" name="description" size="50" value="{{ $part->description }}" />
            </div>

            <div class="form-group">
                <label for="group_id">Name :</label>
                <select class="form-control" name="group_id" value="{{  $part->group_id  }}">
                    @foreach($groups as $group)
                    <option value="{{$group->id}}" {{$part->group_id==$group->id ? 'selected' : ''}}>{{$group->name}}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="cost">Cost:</label>
                <input type="text" class="form-control" name="cost" size="12" value="{{ $part->cost }}" />
            </div>


            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" name="price" size="12" value="{{ $part->price }}" />
            </div>

            <div class="form-group">
                <label for="supplier_no">Supplier Part No.:</label>
                <input type="text" class="form-control" name="supplier_no" size="30" value="{{ $part->supplier_no }}" />
            </div>

            <div class="form-group">
                <label for="stock_item">Stock Item :</label>
                <input type="hidden" class="form-control" name="stock_item[1]" value="0" />
                <input type="checkbox" class="form-control" name="stock_item[0]" value="{{ $part->stock_item }}"
                    @if($part->stock_item==1) checked @endif />

            </div>

            <div class="form-group">
                <label for="count">Count:</label>
                <input type="text" class="form-control" name="count" size="20" value="{{ $part->count }}" />
            </div>

            <div class="form-group">
                <label for="cost">Notes :</label>
                <textarea class="form-control" name="notes">{{ $part->notes }} </textarea>
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{route('parts.index')}}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>



@endsection