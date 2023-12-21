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

/* .badge-primary {
    color: #fff;
    background-color: #007bff;
}

.badge-info {
    color: #fff;
    background-color: #17a2b8;
}

.badge-success {
    color: #fff;
    background-color: rgb(25, 135, 84);
} */

.input-group-text.text-body {
    z-index: 1;
}

.modal-sm {
    max-width: 600px;
}

label {
    margin: 0;
}

li > span {
    font-size: 14px;
}
</style>
    <?php
        use App\Enum\UserEnum;
    ?>
    @include('user.update')
    <div class="card mb-4" id="user-table">
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
                                    <div style="display: flex; align-items: center; gap: 5px">
                                        <div class="text-xs text-secondary mb-0 col-image">
                                            <img
                                                class="avatar avatar-lg me-3"
                                                src="{{$user->avatar}}"
                                                alt=""
                                            >
                                        </div>
                                        <h6 class="mb-0 text-sm">{{$user->first_name . " " . $user->last_name}}</h6>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0" style="max-width: 150px; overflow:hidden;">{{$user->description}}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{$user->birthday}}</p>
                                </td>
                                <td>
                                    @switch($user->role)
                                        @case(UserEnum::ROLE_ADMIN->value)
                                            <span class="badge bg-gradient-primary">Admin</span>
                                            @break
                                        @case(UserEnum::ROLE_LESSOR->value)
                                            <span class="badge bg-gradient-info">Lessor</span>
                                            @break
                                        @case(UserEnum::ROLE_LESSEE->value)
                                            <span class="badge bg-gradient-secondary">Lessee</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="align-middle">
                                    <p class="text-xs text-secondary mb-0 align-middle">
                                        <label class="switch" style="margin: 0">
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
                                <td class="align-middle" style="font-size:20px">
                                    <!-- trigger modal -->
                                    <span class="text-secondary mx-1 font-weight-bold text-xs cursor-pointer" data-toggle="tooltip"
                                        data-bs-toggle="modal" data-bs-target="#userDetail"
                                        data-original-title="User detail" onclick="handleViewDetail({{ $user }})">
                                        <i style="font-size:20px" class="fa-solid fa-eye"></i>
                                    </span>
                                    <!-- show edit form -->
                                    <span class="text-secondary mx-1 font-weight-bold cursor-pointer text-xs" data-toggle="tooltip"
                                        data-original-title="Edit house" onclick="handleEditForm({{ $user }})">
                                        <i style="font-size: 20px; color: #2196F3" class="fa-solid fa-pen-to-square"></i>
                                    </span>
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

    {{--MODAL USER DETAIL--}}
    <div class="col-md-4">
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn bg-gradient-info btn-block" data-bs-toggle="modal" data-bs-target="#userDetail">
        SignUp Modal
        </button> -->

        <!-- Modal -->
        <div class="modal fade" id="userDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row" style="margin-left: 0; margin-right:0;">
                            <!-- User image -->
                            <div class="col-3" style="padding-top: 1.5rem; display:flex; justify-content:center;">
                                <img
                                    id="modal-img"
                                    class="avatar avatar-xxl me-3"
                                    src=""
                                    alt=""
                                    style="margin-right: 0 !important;"
                                >
                            </div>
                            <div class="col-9">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-left">
                                        <h3 class="font-weight-bolder text-primary text-gradient">User Detail</h3>
                                        <!-- <p class="mb-0">Enter your email and password to register</p> -->
                                    </div>
                                    <div class="card-body pb-3" style="padding-top: 0; padding-bottom: 1.5rem !important">
                                        <ul class="list-group">
                                            <li class="list-group-item vstack">
                                                <label>Name</label>
                                                <span id="modal-name"></span>
                                            </li>
                                            <li class="list-group-item vstack">
                                                <label>Email</label>
                                                <span id="modal-email"></span>
                                            </li>
                                            <li class="list-group-item vstack">
                                                <label>Region</label>
                                                <span id="modal-region"></span>
                                            </li>
                                            <li class="list-group-item vstack">
                                                <label>Ward</label>
                                                <span id="modal-ward"></span>
                                            </li>
                                            <li class="list-group-item vstack">
                                                <label>Birthday</label>
                                                <span id="modal-birthday"></span>
                                            </li>
                                            <li class="list-group-item vstack">
                                                <label>Status</label>
                                                <span id="modal-status" class="badge" style="width:fit-content;"></span>
                                            </li>
                                            <li class="list-group-item vstack">
                                                <label>Description</label>
                                                <span id="modal-description"></span>
                                            </li>
                                            
                                        </ul>
                                        
                                    </div>
                                    <!-- <div class="card-footer text-center pt-0 px-sm-4 px-1">
                                        <p class="mb-4 mx-auto">
                                            Already have an account?
                                            <a href="javascrpt:;" class="text-primary text-gradient font-weight-bold">Sign in</a>
                                        </p>
                                    </div> -->
                                </div>
    
                            </div>

                        </div>
                    </div>
                </div>
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
            // let API_GET_ADDRESS     = "{{ route('address.list') }}";
            // let API_UPDATE_STATUS   = "{{route('house.update.status')}}";
            // let API_HOUSE_DETAIL    = "{{route('lessor.house.detail')}}";
            let API_USER_UPDATE     = "{{route('admin.user.update')}}";
            let API_USERS_INDEX     = "{{route('admin.user.index')}}";
        </script>
        <!-- <script src="{{ asset('js/address.js') }}"></script> -->
        <script src="{{ asset('js/user.js') }}"></script>
    @endpush
@endsection
