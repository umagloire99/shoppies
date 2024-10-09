@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">
            Create product
        </h6>
        <div class="ml-auto">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Back to products</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name" class="text-small text-uppercase">{{ __('Product Name Fr') }}</label>
                        <input id="name" type="text" class="form-control form-control-lg" name="name[fr]" value="{{ old('name[fr]') }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="name" class="text-small text-uppercase">{{ __('Product Name En') }}</label>
                        <input id="name" type="text" class="form-control form-control-lg" name="name[en]" value="{{ old('name[en]') }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap">
                @foreach ($countries as $country)
                <div class="col-6">
                    <label class="text-small text-uppercase">{{ __($country->name) }}</label>
                    <div class="row ">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-lg" name="{{ $country->short_name . '_price' }}" placeholder="Price" value="{{ old($country->short_name . '_price') }}">
                                @error($country->short_name . '_price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="number" placeholder="Quantity" class="form-control form-control-lg" name="{{ $country->short_name . '_quantity' }}" value="{{ old($country->short_name . '_quantity') }}">
                                @error($country->short_name . '_quantity')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <br />
                        <select name="category_id" id="category_id" class="form-control">
                            @forelse($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : null }}>
                                {{ $category->name }}
                            </option>
                            @empty
                            @endforelse
                        </select>
                        @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status') == '1' ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="description" class="text-small text-uppercase">{{ __('Description Fr') }}</label>
                        <textarea name="description[fr]" rows="3" class="form-control editor">{!! old('description[fr]') !!}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="description" class="text-small text-uppercase">{{ __('Description En') }}</label>
                        <textarea name="description[en]" rows="3" class="form-control editor">{!! old('description[en]') !!}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="details" class="text-small text-uppercase">{{ __('Details Fr') }}</label>
                        <textarea name="details[fr]" rows="3" class="form-control editor">{!! old('details[fr]') !!}</textarea>
                        @error('details')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="details" class="text-small text-uppercase">{{ __('Details En') }}</label>
                        <textarea name="details[en]" rows="3" class="form-control editor">{!! old('details[en]') !!}</textarea>
                        @error('details')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="usages" class="text-small text-uppercase">{{ __('Usages Fr') }}</label>
                        <textarea name="usages[fr]" rows="3" class="form-control editor">{!! old('usages[fr]') !!}</textarea>
                        @error('usages')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="usages" class="text-small text-uppercase">{{ __('Usages En') }}</label>
                        <textarea name="usages[en]" rows="3" class="form-control editor">{!! old('usages[en]') !!}</textarea>
                        @error('usages')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="features" class="text-small text-uppercase">{{ __('Features Fr') }}</label>
                        <textarea name="features[fr]" rows="3" class="form-control editor">{!! old('features[fr]') !!}</textarea>
                        @error('features')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="features" class="text-small text-uppercase">{{ __('Features En') }}</label>
                        <textarea name="features[en]" rows="3" class="form-control editor">{!! old('features[en]') !!}</textarea>
                        @error('features')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="images">images/video</label>
                    <br>
                    <div class="file-loading">
                        <input type="file" name="images[]" required id="product-images" class="file-input-overview" multiple="multiple">
                    </div>
                    @error('images')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ __('Create') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var ckeditorTextareaList = document.querySelectorAll('.editor');
    for (var i = 0; i < ckeditorTextareaList.length; ++i) {
        CKEDITOR.replace(ckeditorTextareaList[i].getAttribute('name'), {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            toolbar: [
                {
                    name: 'paragraph',
                    groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']
                },
                {
                    name: 'styles',
                    items: ['Format', 'FontSize', 'fontColor']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'align',
                    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                },
                {
                    name: 'document',
                    items: ['Source']
                },
                '/',
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table', 'HorizontalRule']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                }
            ]
        });
    }
</script>

<script>
    $(function() {
        // editor
        // $('.editor').editor({
        //     tabSize: 2,
        //     height: 200,
        //     toolbar: [
        //         ['style', ['style']],
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['color', ['color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['table', ['table']],
        //         ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ]
        // })

        // upload images
        $("#product-images").fileinput({
            theme: "fas",
            maxFileCount: 5,
            allowedFileTypes: ['image', 'video'],
            showCancel: true,
            showRemove: true,
            showUpload: false,
            overwriteInitial: false
        });


        // select2
        function matchStart(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Skip if there is no 'children' property
            if (typeof data.children === 'undefined') {
                return null;
            }

            // `data.children` contains the actual options that we are matching against
            var filteredChildren = [];
            $.each(data.children, function(idx, child) {
                if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) === 0) {
                    filteredChildren.push(child);
                }
            });

            // If we matched any of the timezone group's children, then set the matched children on the group
            // and return the group object
            if (filteredChildren.length) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.children = filteredChildren;

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $(".select2").select2({
            tags: true,
            closeOnSelect: false,
            minimumResultsForSearch: Infinity,
            matcher: matchStart
        });
    })
</script>
@endsection
