<?php
        use App\Enum\UserEnum;
?>
<div id="update-form" style="{{($errors->isEmpty()) ? 'display: none' : 'display: block'}}" class="card mb-4">
    <form class="mx-4 pt-4">
        @csrf
        <input type="hidden" id="user-id" name="id"/>
        <!-- First name + last name -->
        <div class="row">
            <div class="form-group col-6">
                <label for="first-name-update">
                    First Name
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('first_name') ?? ''}}
                    </p>
                </label>
                <input type="text" class="form-control" id="first-name-update" name="first_name">
            </div>
            <div class="form-group col-6">
                <label for="last-name-update">
                    Last Name
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('last_name') ?? ''}}
                    </p>
                </label>
                <input type="text" class="form-control" id="last-name-update" name="last_name">
            </div>
        </div>

        <div class="row mt-3">
            <!-- Email -->
            <div class="form-group col-6">
                <label for="email-update">
                    Email
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('email') ? $errors->first('email') : ''}}
                    </p>
                </label>
                <input type="text" class="form-control" id="email-update" name="email" readonly>
            </div>
            <!-- Birthday -->
            <div class="form-group col-6">
                <label for="birthday-update">
                    Birthday
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('birthday') ? $errors->first('birthday') : ''}}
                    </p>
                </label>
                <input type="date" class="form-control" id="birthday-update" name="birthday">
            </div>
        </div>

        <div class="row mt-3">
            <!-- Region -->
            <div class="form-group col-6">
                <label for="region-update">
                    Region
                    <!-- <span class="text-error">(*)</span> -->
                    <p class="text-error">
                        {{ $errors->has('region') ? $errors->first('region') : ''}}
                    </p>
                </label>
                <input type="text" class="form-control" id="region-update" name="region">
            </div>
            <!-- Ward -->
            <div class="form-group col-6">
                <label for="ward-update">
                    Ward
                    <!-- <span class="text-error">(*)</span> -->
                    <p class="text-error">
                        {{ $errors->has('ward_code') ? $errors->first('ward_code') : ''}}
                    </p>
                </label>
                <select
                    name="ward_code"
                    id="ward-update"
                    class="select form-control mb-3"
                    aria-label="form-select-lg example"
                >
                    @foreach ($wards as $ward)
                        <option value="{{$ward->code}}">{{$ward->name_en}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <!-- Role -->
            <div class="form-group col-6">
                <label for="role-update">
                    Role
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('role') ? $errors->first('role') : ''}}
                    </p>
                </label>
                <select
                    name="role"
                    id="role-update"
                    class="select form-control mb-3"
                    aria-label="form-select-lg example"
                >
                    <option value="{{ UserEnum::ROLE_ADMIN }}">{{ UserEnum::ROLE_ADMIN }}</option>
                    <option value="{{ UserEnum::ROLE_LESSOR }}">{{ UserEnum::ROLE_LESSOR }}</option>
                    <option value="{{ UserEnum::ROLE_LESSEE }}">{{ UserEnum::ROLE_LESSEE }}</option>
                </select>
            </div>
            <!-- Status -->
            <div class="form-group col-6">
                <label for="status-update">
                    Status
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('status') ? $errors->first('status') : ''}}
                    </p>
                </label>
                <select
                    name="status"
                    id="status-update"
                    class="select form-control mb-3"
                    aria-label="form-select-lg example"
                >
                    <option value="{{ UserEnum::STATUS_INACTIVE }}">Inactive</option>
                    <option value="{{ UserEnum::STATUS_ACTIVE }}">Active</option>
                </select>
            </div>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="inputCity">
                Description
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('description') ? $errors->first('description') : ''}}
                </p>
            </label>
            <textarea name="description" class="form-control" id="description-update" cols="20" rows="5"></textarea>
        </div>

{{--        <div class="row">--}}
{{--            <div class="form-group col-4">--}}
{{--                <label for="inputCity">--}}
{{--                    Province--}}
{{--                    <span class="text-error">(*)</span>--}}
{{--                    <p class="text-error">--}}
{{--                        {{ $errors->has('province_code') ? $errors->first('province_code') : ''}}--}}
{{--                    </p>--}}
{{--                </label>--}}
{{--                <select--}}
{{--                    name="province_code"--}}
{{--                    id="province_code-update"--}}
{{--                    style="height: 50px;"--}}
{{--                    class="select form-control mb-3"--}}
{{--                    aria-label=".form-select-lg example"--}}
{{--                >--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="form-group col-4">--}}
{{--                <label for="inputCity">--}}
{{--                    District--}}
{{--                    <span class="text-error">(*)</span>--}}
{{--                    <p class="text-error">--}}
{{--                        {{ $errors->has('district_code') ? $errors->first('district_code') : ''}}--}}
{{--                    </p>--}}
{{--                </label>--}}
{{--                <select--}}
{{--                    name="district_code"--}}
{{--                    id="district_code-update"--}}
{{--                    style="height: 50px;"--}}
{{--                    class="select form-control mb-3"--}}
{{--                    aria-label=".form-select-lg example"--}}
{{--                >--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="form-group col-4">--}}
{{--                <label for="inputCity">--}}
{{--                    Ward--}}
{{--                    <span class="text-error">(*)</span>--}}
{{--                    <p class="text-error">--}}
{{--                        {{ $errors->has('ward_code') ? $errors->first('ward_code') : ''}}--}}
{{--                    </p>--}}
{{--                </label>--}}
{{--                <select--}}
{{--                    name="ward_code"--}}
{{--                    id="ward_code-update"--}}
{{--                    style="height: 50px;"--}}
{{--                    class="select form-control mb-3"--}}
{{--                    aria-label=".form-select-lg example"--}}
{{--                >--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="inputCity">--}}
{{--                Address--}}
{{--                <span class="text-error">(*)</span>--}}
{{--                <p class="text-error">--}}
{{--                    {{ $errors->has('address') ? $errors->first('address') : ''}}--}}
{{--                </p>--}}
{{--            </label>--}}
{{--            <input type="text" class="form-control"--}}
{{--                name="address" id="address-update">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="inputCity">--}}
{{--                Category--}}
{{--                <span class="text-error">(*)</span>--}}
{{--                <p class="text-error">--}}
{{--                    {{ $errors->has('province_code') ? $errors->first('province_code') : ''}}--}}
{{--                </p>--}}
{{--            </label>--}}
{{--            <select--}}
{{--                name="category_id"--}}
{{--                id="category-update"--}}
{{--                style="height: 50px;"--}}
{{--                class="select form-control mb-3"--}}
{{--                aria-label=".form-select-lg example"--}}
{{--            >--}}
{{--                @foreach ($category as $item)--}}
{{--                    <option value="{{$item->id}}">{{$item->name_vi}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}

        <!-- Avatar -->
        <div class="form-group row">
            <label for="avatar-update">
                Avatar
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('avatar') ? $errors->first('avatar') : ''}}
                </p>
            </label>
            <input type="file" name="avatar" id="avatar-update" hidden accept="image/*" />
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card h-100 card-plain border cover-image">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <i class="fa fa-plus text-secondary mb-3"></i>
                        <h5 class="text-secondary"> Avatar </h5>
                    </div>
                </div>
            </div>
        </div>
        <span class="btn btn-secondary cancel-update-btn">Close</span>
        <button type="button" class="btn btn-primary user-update">Update</button>
    </form>
</div>
