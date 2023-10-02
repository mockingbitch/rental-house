@extends('layout')
@section('content')
<h2>{{__('category_update')}}</h2>

<div class="card mb-4">
    <form class="mx-4 pt-4" method="post" enctype="multipart/form-data"
        action="{{route('category.update', ['id'=>$category->id])}}">
        @csrf
        <div class="form-group mt-4">
            <label for="inputName">{{__('category_name_vi')}} @if ($errors->has('name_vi'))<p class="text-error">*{{$errors->first('name_vi')}}</p>@endif</label>
            <input type="text" name="name_vi" class="form-control" id="inputName" aria-describedby="nameHelp" value="{{$category->name_vi}}">
        </div>
        <div class="form-group mt-4">
            <label for="inputName">{{__('category_name_en')}} @if ($errors->has('name_en'))<p class="text-error">*{{$errors->first('name_en')}}</p>@endif</label>
            <input type="text" name="name_en" class="form-control" id="inputNameEn" aria-describedby="nameHelp" value="{{$category->name_en}}">
        </div>
        <div class="form-group mt-4">
            <label for="inputDescription">{{__('category_description_vi')}}</label>
            <input type="text" name="description_vi" class="form-control" id="inputDescription" aria-describedby="nameHelp" value="{{$category->description_vi}}">
        </div>
        <div class="form-group mt-4">
            <label for="inputDescription">{{__('category_description_en')}}</label>
            <input type="text" name="description_en" class="form-control" id="inputDescriptionEn" aria-describedby="nameHelp" value="{{$category->description_en}}">
        </div>
        <div class="form-group">
            <label for="inputCity">Icon @if ($errors->has('icon'))<p class="text-error">*{{$errors->first('icon')}}</p>@endif</label>
            <input type="text" class="form-control"
                name="icon" id="icon" value="{{$category->icon}}"
                placeholder="Enter Icon">
        </div>
        <div class="form-group mt-4">
            <label for="optionStatus">{{__('status')}} @if ($errors->has('status'))<p class="text-error">*{{$errors->first('status')}}</p>@endif</label>
            <select name="status" id="optionStatus" style="width: 50%; height: 50px;" class="select form-control mb-3" aria-label=".form-select-lg example">
                <option value="1" {{$category->status == 1 ? 'selected' : ''}}>{{__('display')}}</option>
                <option value="0" {{$category->status == 0 ? 'selected' : ''}}>{{__('hide')}}</option>
            </select>
        </div>
        <br>
        <a class="btn btn-danger"
            onclick="confirmDelete({{$category->id}})">
            {{__('delete')}}
        </a>
        <button type="submit" class="btn btn-primary">{{__('update')}}</button>
    </form>
</div>
@if (Session::has('msg'))
    <script>
        swal({title:"{{__('success')}}", text:"{{Session::get('msg')}}", icon:"success", button:"{{__('close')}}",});
    </script>
@endif
@if (Session::has('errMsg'))
    <script>
        swal({title:"{{__('warning')}}", text:"{{Session::get('errMsg')}}", icon:"warning", button:"{{__('close')}}",});
    </script>
@endif
<script>
    function confirmDelete(id) {
        swal({
            title: "Bạn có muốn xoá mục này?",
            text: "Dữ liệu xoá sẽ không thể khôi phục!",
            icon: "warning",
            buttons: [
                'Huỷ',
                'Xoá'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.get("{{route('category.delete')}}", {"id": id}, function(data) {
                    var url = '{{ route("category.get") }}';
                    swal({
                        title: 'Đã xoá!',
                        text: 'Xoá thành công mục này!',
                        icon: 'success'
                    }).then(function() {
                        setTimeout(() => {
                            location.replace(url)
                        }, 500);
                    });
                });
            } else {
                swal("Huỷ", "Dữ liệu của bạn vẫn an toàn :)", "error");
            }
        })
    }
</script>
@endsection
