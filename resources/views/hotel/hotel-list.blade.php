@extends('layout')
@section('content')
<div class="create-btn mx-3 my-3">
    <button onclick="create()" class="btn btn-primary "style="all: unset; cursor: pointer; font-size:20px; color: green; z-index: 1999"><i class="fa-solid fa-circle-plus">Add new</i></button>
</div>
<span style="font-size:20px; color: green">{{$msg ? $msg : ''}}</span>
<div id="create-form" style="display: none" class="card mb-4">
   <form class="mx-4 pt-4" method="post" enctype="multipart/form-data">
    @csrf
  <div class="form-group mt-4">
    <label for="inputName">Hotel name</label>
    <input type="text" name="name" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Enter hotel name">
  </div>
  <div class="form-group">
    <label for="inputCity">City</label>
    <input type="text" class="form-control" name="city" id="inputCity" placeholder="Enter city">
  </div>
  <div class="form-group">
    <label for="inputHotline">Hotline</label>
    <input type="text" class="form-control" name="hotline" id="inputHotline" placeholder="Enter hotline">
  </div>
  <div class="form-group">
    <label for="inputDescription">Description</label>
    <input type="text" class="form-control" name="description" id="inputDescription" placeholder="Enter description">
  </div>
  <div class="form-group">
    <label for="inputImage">Image</label>
    <input type="file" class="form-control" name="image" id="inputImage" placeholder="Upload image">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<div class="card mb-4">
  @if (count($hotels) >= 1)          
    <div class="card-header pb-0">
      <h6>Hotels table</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hotel</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">City</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hotline</th>
              <th class="text-secondary opacity-7"></th>
            </tr>
          </thead>
          <tbody>
              @foreach ($hotels as $hotel)                          
            <tr>
              <td>
                <div class="d-flex px-2 py-1">
                  <div>
                    <img src="{{asset('uploads/hotels/'.$hotel->image)}}" class="avatar avatar-lg me-3" alt="user1">
                  </div>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">{{$hotel->name}}</h6>
                  </div>
                </div>
              </td>
              <td>
                <p class="text-xs text-secondary mb-0">{{$hotel->city}}</p>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-gradient-success">{{$hotel->hotline}}</span>
              </td>
              <td class="align-middle" style="font-size:20px">
                <a href="{{route('hotel.show',['id'=>$hotel->id])}}" class="text-secondary mx-1 font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                  <i style="font-size:20px" class="fa-solid fa-pen-to-square"></i>
                </a>
                <a onclick="return confirm('Are you sure you want to delete this?')" href="{{route('hotel.delete',['id'=>$hotel->id])}}" class="text-secondary mx-1 font-weight-bold text-xs" data-toggle="tooltip">
                  <i style="font-size:20px" class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
    </div>
  @else 
  <h2 class="my-4 mx-4">No hotel found</h2>
  @endif
<script>
function create() {
  var x = document.getElementById("create-form");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
@endsection