<div id="create-form" style="{{($errors->isEmpty()) ? 'display: none' : 'display: block'}}" class="card mb-4">
    <form class="mx-4 pt-4"
        method="post"
        action="{{route('lessor.house.create')}}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="form-group mt-4">
            <label for="inputName">
                Name
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('name') ? $errors->first('name') : ''}}
                </p>
            </label>
            <input type="text" class="form-control"
                id="nameVi" name="name" value="{{old('name')}}"
                placeholder="House name">
        </div>
        <div class="form-group">
            <label for="inputCity">
                Description
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('description') ? $errors->first('description') : ''}}
                </p>
            </label>
            <textarea name="description" class="form-control" id="" cols="20" rows="10"></textarea>
        </div>
        <div class="row">
            <div class="form-group col-4">
                <label for="inputCity">
                    Province
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('province_code') ? $errors->first('province_code') : ''}}
                    </p>
                </label>
                <select
                    name="province_code"
                    id="province_code-add"
                    style="height: 50px;"
                    class="select form-control mb-3"
                    aria-label=".form-select-lg example"
                >
                </select>
            </div>
            <div class="form-group col-4">
                <label for="inputCity">
                    District
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('district_code') ? $errors->first('district_code') : ''}}
                    </p>
                </label>
                <select
                    name="district_code"
                    id="district_code-add"
                    style="height: 50px;"
                    class="select form-control mb-3"
                    aria-label=".form-select-lg example"
                >
                </select>
            </div>
            <div class="form-group col-4">
                <label for="inputCity">
                    Ward
                    <span class="text-error">(*)</span>
                    <p class="text-error">
                        {{ $errors->has('ward_code') ? $errors->first('ward_code') : ''}}
                    </p>
                </label>
                <select
                    name="ward_code"
                    id="ward_code-add"
                    style="height: 50px;"
                    class="select form-control mb-3"
                    aria-label=".form-select-lg example"
                >
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCity">
                Address
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('address') ? $errors->first('address') : ''}}
                </p>
            </label>
            <input type="text" class="form-control"
                name="address" id="address"
                placeholder="Enter your specific address">
        </div>
        <div class="form-group row">
            <label for="inputCity">
                Thumbnail
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('thumbnail') ? $errors->first('thumbnail') : ''}}
                </p>
            </label>
            <input type="file" name="thumbnail" id="thumbnail" hidden accept="image/*" />
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card h-100 card-plain border">
                    <div class="card-body d-flex flex-column justify-content-center text-center add-thumbnail">
                        <i class="fa fa-plus text-secondary mb-3"></i>
                        <h5 class="text-secondary"> Thumbnail </h5>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>