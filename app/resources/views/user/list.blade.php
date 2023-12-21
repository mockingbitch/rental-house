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

.badge {

}
</style>
    <?php
        use App\Enum\UserEnum;
    ?>
{{UserEnum::ROLE_ADMIN}}
    @if (isset($user) && $user->role == UserEnum::ROLE_ADMIN)
        <div class="create-btn mx-3 my-3">
            <button onclick="create()"
                class="btn btn-primary "style="all: unset; cursor: pointer; font-size:20px; color: green; z-index: 1999">
                <i class="fa-solid fa-circle-plus">Add</i>
            </button>
        </div>
        <span style="font-size:20px; color: green"></span>
{{--        @include('lessor.house.create-form', ['category' => $category])--}}
    @endif
{{--    @include('lessor.house.update')--}}
    <div class="card mb-4">
        @if (isset($users) && count($users) >= 1)
            <div class="card-header pb-0">
                <h6>User table</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lessor</th> --}}
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Birthday</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                            {{-- <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{$house->lessor->name}}</h6>
                                    </div>
                                </div>
                            </td> --}}
                                <td>
                                    <div class="text-xs text-secondary mb-0 col-image">
                                        <img
                                            style="width: 50px; border-radius: 15px;"
                                            src="{{$user->avatar}}"
                                            alt=""
                                        >
                                    </div>
                                    <h6 class="mb-0 text-sm">{{$user->first_name . " " . $user->last_name}}</h6>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{$user->description}}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{$user->birthday}}</p>
                                </td>
                                <td>
                                    @switch($user->role)
                                        @case(UserEnum::ROLE_ADMIN->value)
                                            <span class="badge badge-primary">Admin</span>
                                            @break
                                        @case(UserEnum::ROLE_LESSOR)
                                            <span class="badge badge-primary">Lessor</span>
                                            @break
                                        @case(UserEnum::ROLE_LESSEE)
                                            <span class="badge badge-primary">Lessee</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">
                                        <label class="switch">
                                            <input
                                                type="checkbox"
                                                onclick="updateStatus({{ $user->id }}, {{ $user->status }})"
                                                id="status_{{$user->id}}"
                                                {{ $user->status == 1 ? 'checked' : '' }}
                                            >
                                            <span class="slider round"></span>
                                        </label>
                                    </p>
                                </td>
{{--                                <td class="align-middle text-center text-sm">--}}
{{--                                    <span class="badge badge-sm bg-gradient-success"></span>--}}
{{--                                </td>--}}
                                <td class="align-middle" style="font-size:20px">
{{--                                    <a--}}
{{--                                       href="{{route('lessor.house.room-list', ['id' => $house->id])}}"--}}
{{--                                       class="text-secondary mx-1 font-weight-bold text-xs" data-toggle="tooltip">--}}
{{--                                        <i style="font-size:20px" class="fa-solid fa-eye"></i>--}}
{{--                                    </a>--}}
{{--                                    <span class="text-secondary mx-1 font-weight-bold cursor-pointer text-xs" data-toggle="tooltip"--}}
{{--                                        data-original-title="Edit house" onclick="handleViewDetail({{$house->id}})">--}}
{{--                                        <i style="font-size: 20px; color: #2196F3" class="fa-solid fa-pen-to-square"></i>--}}
{{--                                    </span>--}}
{{--                                    <a onclick="return confirm('Are you sure you want to delete this?')"--}}
{{--                                        href="{{route('lessor.house.delete', ['id' => $house->id])}}"--}}
{{--                                        class="text-secondary mx-1 font-weight-bold text-xs" data-toggle="tooltip">--}}
{{--                                        <i style="font-size:20px" class="fa-solid fa-trash"></i>--}}
{{--                                    </a>--}}
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
            let API_GET_ADDRESS     = "{{ route('address.list') }}";
            let API_UPDATE_STATUS   = "{{route('house.update.status')}}";
            let API_HOUSE_DETAIL    = "{{route('lessor.house.detail')}}";
            let API_HOUSE_UPDATE    = "{{route('lessor.house.update')}}";
        </script>
        <script src="{{ asset('js/address.js') }}"></script>
        <script src="{{ asset('js/house.js') }}"></script>
    @endpush
@endsection
