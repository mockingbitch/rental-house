@extends('layout')
@section('content')
    <div class="create-btn mx-3 my-3">
        <button onclick="create()"
            class="btn btn-primary "style="all: unset; cursor: pointer; font-size:20px; color: green; z-index: 1999">
            <i class="fa-solid fa-circle-plus">Add new</i>
        </button>
    </div>
    <span style="font-size:20px; color: green"></span>
    @include('lessor.house.create-form')
    <div class="card mb-4">
        @if (isset($houses) && count($houses) >= 1)
        <div class="card-header pb-0">
            <h6>House table</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name_vi</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name_en</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description_vi</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description_en</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Icon</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($houses as $house)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{$house->name_vi}}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs text-secondary mb-0">{{$house->name_en}}</p>
                            </td>
                            <td>
                                <p class="text-xs text-secondary mb-0">{{$house->description_vi}}</p>
                            </td><td>
                                <p class="text-xs text-secondary mb-0">{{$house->description_en}}</p>
                            </td><td>
                                <p class="text-xs text-secondary mb-0">{{$house->icon}}</p>
                            </td><td>
                                <p class="text-xs text-secondary mb-0">{{$house->status}}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm bg-gradient-success"></span>
                            </td>
                            <td class="align-middle" style="font-size:20px">
                                <a class="text-secondary mx-1 font-weight-bold text-xs" data-toggle="tooltip"
                                    data-original-title="Edit house" href="{{route('lessor.house.detail', ['id' => $house->id])}}">
                                    <i style="font-size:20px" class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a onclick="return confirm('Are you sure you want to delete this?')"
                                    href="{{route('lessor.house.delete',['id'=>$house->id])}}"
                                    class="text-secondary mx-1 font-weight-bold text-xs" data-toggle="tooltip">
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
    <h2 class="my-4 mx-4">No house found</h2>
    @endif
    @if(Session::has('errCode') && Session::get('errCode') ==  1)
        <script>
            swal({title: "successfuly", text: "{{Session::get('msg')}}", icon: "success", button: "{{__('close')}}"})
        </script>
    @endif
    @if(Session::has('errCode') && Session::get('errCode') == 0)
        <script>
            swal({title: "failurely", text: "{{Session::get('errMsg')}}", icon: "warning", button: "{{__('close')}}"})
        </script>
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
