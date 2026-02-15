@extends('layouts.admin.template')
@section('title', 'Admin | Upload Foto Profil')
@section('css')
    {{-- Css CROP --}}
    <link rel="stylesheet" href="{{ asset('/lte4/ijaboCropTool/ijaboCropTool.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Upload Profil</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.profil') }}">Profil</a></li>
                            <li class="breadcrumb-item active">Upload</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        @if ($foto != null)
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle image-previewer"
                                    style="width: 200px!important;" src='{{ asset("/foto/$foto") }}'
                                    alt="User profile picture">
                            </div>
                        @else
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle image-previewer"
                                    style="width: 200px!important;" src='#' alt="User profile picture">
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="exampleInputFile">Upload Foto</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="foto" id="foto" accept="image/png, image/jpeg">
                                    <label class="custom-file-label" for="foto">Pilih File Foto</label>
                                </div>
                            </div>
                            <small class="text-secondary">*Upload foto JPG | PNG | JPEG</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.profil') }}" class="btn btn-primary w-100">Kembali</a>
                    </div>
                </div>
                {{-- </form> --}}
            </div>
        </section>
    </div>
@endsection
@section('script')
    {{-- Script Css Crop --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('/lte4/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
    <script>
        var url = "{{ route('admin.profil.crop') }}";
        $('#foto').ijaboCropTool({
            preview: '.image-previewer',
            setRatio: 1,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['CROP', 'QUIT'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: url,
            withCSRF: ['_token', '{{ csrf_token() }}'],
            onSuccess: function(message, element, status) {
                alert(message);
                location.href = "{{ route('admin.profil') }}"
            },
            onError: function(message, element, status) {
                alert(message);
            }
        });
    </script>
@endsection
