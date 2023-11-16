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
                    {{ $errors->has('name_en') ? $errors->first('name_en') : ''}}
                </p>
            </label>
            <input type="text" class="form-control"
                id="nameVi" name="name_vi" value="{{old('name_vi')}}"
                placeholder="Enter Name_vi">
        </div>
        <div class="form-group">
            <label for="inputCity">
                Description
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('name_en') ? $errors->first('name_en') : ''}}
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
                        {{ $errors->has('name_en') ? $errors->first('name_en') : ''}}
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
                        {{ $errors->has('name_en') ? $errors->first('name_en') : ''}}
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
                        {{ $errors->has('name_en') ? $errors->first('name_en') : ''}}
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
                    {{ $errors->has('name_en') ? $errors->first('name_en') : ''}}
                </p>
            </label>
            <input type="text" class="form-control"
                name="description_en" id="descriptionEn"
                placeholder="Enter Description_en">
        </div>
        <div class="form-group row">
            <label for="inputCity">
                Thumbnail
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('name_en') ? $errors->first('name_en') : ''}}
                </p>
            </label>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card h-100 card-plain border">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                    <a href="javascript:;">
                        <i class="fa fa-plus text-secondary mb-3"></i>
                        <h5 class=" text-secondary"> Thumbnail </h5>
                    </a>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>