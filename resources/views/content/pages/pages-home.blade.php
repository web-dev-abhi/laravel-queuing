@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')
@section('page-style')
    <style>
        #bar {
            transition: all 0.3s ease-in;
        }
    </style>
@endsection

@section('content')
    <h4>Home Page</h4>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="" id="upload-file">
                        <div class="mb-2">
                            <label for="" class="form-label">File</label>
                            <input type="file" required accept=".csv" class="form-control" id="file">
                        </div>
                        <button type="submit" class="btn btn-submit btn-sm btn-primary mt-2">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <span id="progress-text"></span>
                    <br>
                    <div id="progess" class="d-none mt-2 rounded-3 w-100 bg-black border d-flex align-items-center"
                        style="height: 10px;">
                        <div id="bar"
                            class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-medium"
                            style="font-size: 7px; width: 0%; height: 10px">
                            1%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(function() {
            var text = "Waiting for file upload";
            var uploading = "File uplading";
            $('#progress-text').text(text);
            $('#file').on('change', function() {
                $('#progress-text').text(text);
                $('#bar').text('');
                $('#bar').css('width', "0px");
                $('#progess').addClass('d-none');
            });

            $('#upload-file').submit(function(event) {
                event.preventDefault();
                $('#progess').removeClass('d-none');
                var formData = new FormData();
                var fileInput = $('#file')[0]; // Assuming #img1 is your file input element
                var file = fileInput.files[0];
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('type', 'image');
                $.ajax({
                    url: "{{ route('file-upload') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        console.log(res);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('.btn-submit').removeClass('disabled');
                        // console.log(jqXHR);
                    },
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        $('.btn-submit').addClass('disabled');
                        $('#progress-text').text(uploading);
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                var percentComplete = (e.loaded / e.total) * 100;
                                $('#bar').css('width', percentComplete + '%');
                                $('#bar').text(Math.round(percentComplete) +
                                    '%');
                                if (Math.round(percentComplete) == 100) {
                                    $('.btn-submit').removeClass('disabled');
                                }
                            }
                        }, false);
                        return xhr;
                    }
                });
            });
            // console.log('asdsada');
        });
    </script>
@endsection
