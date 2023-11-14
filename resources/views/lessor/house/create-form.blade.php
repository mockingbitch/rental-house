<div id="create-form" style="{{($errors->isEmpty()) ? 'display: none' : 'display: block'}}" class="card mb-4">
    <form class="mx-4 pt-4"
        method="post"
        action="{{route('lessor.house.create')}}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="form-group mt-4">
            <label for="inputName">
                Name_vi
                @if ($errors->has('name_vi'))
                    <p class="text-error">
                        *{{$errors->first('name_vi')}}
                    </p>
                @endif
            </label>
            <input type="text" class="form-control"
                id="nameVi" name="name_vi" value="{{old('name_vi')}}"
                placeholder="Enter Name_vi">
        </div>
        <div class="form-group">
            <label for="inputCity">Name_en @if ($errors->has('name_en'))<p class="text-error">*{{$errors->first('name_en')}}</p>@endif</label>
            <input type="text" class="form-control"
                name="name_en" id="nameEn" value="{{old('name_en')}}"
                placeholder="Enter Name_en">
        </div>
        <div class="form-group">
            <label for="inputCity">Description_vi</label>
            <input type="text" class="form-control"
                name="description_vi" id="descriptionVi"
                placeholder="Enter Description_vi">
        </div>
        <div class="form-group">
            <label for="inputCity">Description_en</label>
            <input type="text" class="form-control"
                name="description_en" id="descriptionEn"
                placeholder="Enter Description_en">
        </div>
        <div class="form-group">
            <label for="inputCity">Icon @if ($errors->has('icon'))<p class="text-error">*{{$errors->first('icon')}}</p>@endif</label>
            <input type="text" class="form-control"
                name="icon" id="icon" value="{{old('icon')}}"
                placeholder="Enter Icon">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>