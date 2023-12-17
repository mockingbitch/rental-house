@extends('layout')
@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="create-btn mx-3 my-3">
        <button class="btn btn-secondary">
            <a href="{{route('lessor.house.index')}}">Back</a>
        </button>
        <button onclick="create()"
                class="btn btn-primary "style="all: unset; cursor: pointer; font-size:20px; color: green; z-index: 1999">
            <i class="fa-solid fa-circle-plus">Add room</i>
        </button>
    </div>
    <span style="font-size:20px; color: green"></span>
    @include('lessor.room.create-form', ['tags' => $tags, 'house_id'   => $house_id])
    @include('lessor.room.update')
    <div class="card mb-4">
        @if (isset($rooms) && count($rooms) >= 1)
            <div class="card-header pb-0">
                <h6>Room list</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lessor</th> --}}
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Floor</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Price</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Capacity</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Thumbnail</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Status</th>
                            <th class="text-secondary opacity-7 text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                {{-- <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$room->lessor->name}}</h6>
                                        </div>
                                    </div>
                                </td> --}}
                                <td>
                                    <h6 class="mb-0 text-sm">{{$room->name}}</h6>
                                </td>
                                <td>
                                    <p class="text-xs text-center text-secondary mb-0">{{$room->floor}}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-center text-secondary mb-0">{{number_format($room->price)}}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-center text-secondary mb-0">{{$room->capacity}}</p>
                                </td>
                                <td>
                                    <div class="text-xs text-secondary mb-0 col-image">
                                        <img
                                            style="width: 100px; border-radius: 15px;"
                                            src="{{$room->first_image}}"
                                            alt=""
                                        >
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0 text-center">
                                        <label class="switch">
                                            <input
                                                type="checkbox"
                                                onclick="updateStatus({{$room->id}}, {{$room->status}})"
                                                id="status_{{$room->id}}"
                                                {{ $room->status == 1 ? 'checked' : '' }}
                                            >
                                            <span class="slider round"></span>
                                        </label>
                                    </p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-success"></span>
                                </td>
                                <td class="align-middle" style="font-size:20px">
                                    {{-- <a
                                        href="{{route('lessor.house.room-list', ['id' => $room->id])}}"
                                        class="text-secondary mx-1 font-weight-bold text-xs" data-toggle="tooltip">
                                        <i style="font-size:20px" class="fa-solid fa-eye"></i>
                                    </a> --}}
                                    <span class="text-secondary mx-1 font-weight-bold cursor-pointer text-xs" data-toggle="tooltip"
                                          data-original-title="Edit room" onclick="handleViewDetail({{$room->id}})">
                                        <i style="font-size: 20px; color: #2196F3" class="fa-solid fa-pen-to-square"></i>
                                    </span>
                                    <a onclick="return confirm('Are you sure you want to delete this?')"
                                       href="{{route('lessor.room.delete', ['id' => $room->id])}}"
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
        <h2 class="my-4 mx-4">No room found</h2>
    @endif
    @if(Session::has('errCode') && Session::get('errCode') == 0)
        <script>
            swal({title: "Successfully", text: "{{Session::get('msg')}}", icon: "success", button: "{{__('close')}}"})
        </script>
    @endif
    @if(Session::has('errCode') && Session::get('errCode') == 1)
        <script>
            swal({title: "Something went wrong", text: "{{Session::get('errMsg')}}", icon: "warning", button: "{{__('close')}}"})
        </script>
    @endif
    @push('scripts')
        <script>
            let API_GET_ADDRESS     = '{{route('address.list')}}';
            let API_UPDATE_STATUS   = '{{route('room.update.status')}}';
            let API_ROOM_DETAIL    = '{{route('lessor.room.detail')}}';
            let API_ROOM_UPDATE    = '{{route('lessor.room.update')}}';
        </script>
        <script src="{{ asset('js/address.js') }}"></script>
        <script src="{{ asset('js/room.js') }}"></script>
    @endpush
@endsection
