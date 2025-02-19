@extends('layouts.app')

@section('content')
    
    <div class="container">
        <h2 class="text-center">Upload Image and Scan</h2>

        
        <form id="imageUploadForm" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="imageInput" class="form-label">Choose an image:</label>
                <input type="file" name="image" id="imageInput" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Analyze Image</button>
        </form>

    
        <div id="imagePreview" class="mt-4" style="display: none;">
            <h4>Image Preview:</h4>
            <div class="image-box">
                <img id="imagePreviewImg" src="" alt="Image Preview" class="img-fluid">
            </div>
        </div>

    
        <h3 class="mt-4">Analysis Result:</h3>
        <pre id="result"></pre>
    </div>


<style>
    .image-box {
        border: 2px solid #ddd;
        padding: 10px;
        border-radius: 10px; 
        max-width: 400px;
        margin-top: 20px;
        text-align: center;
    }

    .image-box img {
        width: 100%;
        border-radius: 8px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
       
        $("#imageInput").on("change", function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
               
                $("#imagePreview").show();
                
                $("#imagePreviewImg").attr("src", e.target.result);
            }
            reader.readAsDataURL(this.files[0]); 
        });

        
        $("#imageUploadForm").on("submit", function(event) {
            event.preventDefault();
            
            var formData = new FormData();
            formData.append("image", $("#imageInput")[0].files[0]);
            formData.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: "{{ url('/analyze-image') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#result").text(JSON.stringify(response, null, 2));
                },
                error: function(xhr) {
                    $("#result").text("Error: " + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
