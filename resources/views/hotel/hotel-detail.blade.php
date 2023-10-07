@extends('layout')
@section('content')
<div class="card mb-4">
  <form class="mx-4 pt-4" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group mt-4">
      <label for="inputName">Hotel name</label>
      <input type="text" name="name" class="form-control" id="inputName" aria-describedby="nameHelp" value="{{$hotel->name}}">
    </div>
    <div class="form-group">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" name="city" id="inputCity" value="{{$hotel->city}}">
    </div>
    <div class="form-group">
      <label for="inputHotline">Hotline</label>
      <input type="text" class="form-control" name="hotline" id="inputHotline" value="{{$hotel->hotline}}">
    </div>
    <div class="form-group">
      <label for="inputDescription">Description</label>
      <input type="text" class="form-control" name="description" id="inputDescription" value="{{$hotel->description}}">
    </div>
    <div class="form-group">
      <label for="inputImage">Image</label>
      <input type="file" class="form-control" name="image" id="inputImage" placeholder="Upload image">
      <div class="mt-3 text-center">
        <img src="{{asset('uploads/hotels/'.$hotel->image)}}" width="500px"  alt="user1">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
@endsection