<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <a href="{{ url('/') }}">Home</a>


    <h2>Create a New Post</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="summernote" name="content"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
            callbacks: {
                onImageUpload: function(files) {
                    let editor = $(this);
                    let data = new FormData();
                    data.append('file', files[0]);

                    $.ajax({
                        url: '/upload-image',
                        method: 'POST',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(url) {
                            console.log('Image uploaded:', url);
                            editor.summernote('insertImage', url);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Upload error:', textStatus, errorThrown);
                        }
                    });
                }
            }
        });
    });
</script>
</body>
</html>
