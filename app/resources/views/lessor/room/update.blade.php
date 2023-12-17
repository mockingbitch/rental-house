<div id="update-form" style="{{($errors->isEmpty()) ? 'display: none' : 'display: block'}}" class="card mb-4">
    <form class="mx-4 pt-4" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="id-update" name="id" />

        <div class="form-group mt-4">
            <label for="inputName">
                Name
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('name') ? $errors->first('name') : ''}}
                </p>
            </label>
            <input type="text" class="form-control"
                   id="name-update" name="name">
        </div>

        <div class="form-group">
            <label for="inputCity">
                Description
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('description') ? $errors->first('description') : ''}}
                </p>
            </label>
            <textarea name="description" class="form-control" id="description-update" cols="20" rows="10"></textarea>
        </div>

        <div class="form-group">
            <label for="inputFloor">
                Floor
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('floor') ? $errors->first('floor') : ''}}
                </p>
            </label>
            <input type="number" class="form-control"
                   name="floor" id="floor-update"
                   placeholder="Floor of the room">
        </div>

        <div class="form-group">
            <label for="inputPrice">
                Price
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('price') ? $errors->first('price') : ''}}
                </p>
            </label>
            <input type="number" class="form-control"
                   name="price" id="price-update"
                   placeholder="Enter the price">
        </div>

        <div class="form-group">
            <label for="inputCapacity">
                Capacity
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('capacity') ? $errors->first('capacity') : ''}}
                </p>
            </label>
            <input type="number" class="form-control"
                   name="capacity" id="capacity-update"
                   placeholder="Capacity of the room">
        </div>

        {{-- house id --}}
        <input type="text" class="form-control"
            name="house_id"
            id="house_id-update"
            placeholder="Floor of the room"
            value="{{ $house_id }}"
            hidden
        >

        <div class="form-group">
            <label for="inputTag">
                Tag
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('tag') ? $errors->first('tag') : ''}}
                </p>
            </label>

            <multi-input>
                <input list="tags" name="tags" id="tags-update" class="form-control">
                <datalist id="tags">
                    @foreach($tags as $tag)
                        <option value="{{$tag->name_vi}}"></option>
                    @endforeach
                </datalist>
            </multi-input>
        </div>

        <div class="form-group row images-element">
            <label for="inputImages">
                Images
                <span class="text-error">(*)</span>
                <p class="text-error">
                    {{ $errors->has('images') ? $errors->first('images') : ''}}
                </p>
            </label>
            <input type="file" name="images[]" id="images-add_0" hidden accept="image/*" />
            <input type="file" name="images[]" id="images-add_1" hidden accept="image/*" />
            <input type="file" name="images[]" id="images-add_2" hidden accept="image/*" />
            <input type="file" name="images[]" id="images-add_3" hidden accept="image/*" />
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 add-images_0" data-id="0">
                <div class="card h-100 card-plain border cover-image_0">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <i class="fa fa-plus text-secondary mb-3"></i>
                        <h5 class="text-secondary"> Images </h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 add-images_1" data-id="1">
                <div class="card h-100 card-plain border cover-image_1">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <i class="fa fa-plus text-secondary mb-3"></i>
                        <h5 class="text-secondary"> Images </h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 add-images_2" data-id="2">
                <div class="card h-100 card-plain border cover-image_2">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <i class="fa fa-plus text-secondary mb-3"></i>
                        <h5 class="text-secondary"> Images </h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 add-images_3" data-id="3">
                <div class="card h-100 card-plain border cover-image_3">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <i class="fa fa-plus text-secondary mb-3"></i>
                        <h5 class="text-secondary"> Images </h5>
                    </div>
                </div>
            </div>
        </div>
        <span class="btn btn-secondary cancel-update-btn" id="update-close">Close</span>
        <button type="button" class="btn btn-primary room-update">Update</button>
    </form>
</div>
