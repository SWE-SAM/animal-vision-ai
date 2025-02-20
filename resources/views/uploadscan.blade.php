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

        <!-- Image Preview -->
        <div id="imagePreview" class="mt-4" style="display: none;">
            <h4>Image Preview:</h4>
            <div class="image-box">
                <img id="imagePreviewImg" src="" alt="Image Preview" class="img-fluid">
            </div>
        </div>

        <!-- Analysis Result -->
        <div id="analysisResult" class="mt-4" style="display: none;">
            <h3>Analysis Result:</h3>

            <h4>Detected Objects:</h4>
            <ul id="objectList" class="list-group"></ul>

            <h4>Image Tags:</h4>
            <ul id="tagList" class="list-group"></ul>

            <h4>Description:</h4>
            <p id="captionText" class="fw-bold"></p>
        </div>
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

    #analysisResult {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    h4 {
        margin-top: 10px;
        color: #333;
    }

    .list-group-item {
        background: #fff;
        margin: 5px 0;
        padding: 8px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        // Image preview on file selection
        $("#imageInput").on("change", function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").show();
                $("#imagePreviewImg").attr("src", e.target.result);
            }
            reader.readAsDataURL(this.files[0]); 
        });

        // Handle Image Upload and Analysis
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
                    if (response.tags || response.description || response.objects) {
                        $("#analysisResult").show();
                        $("#result").hide(); // Hide the raw JSON output

                        // Process detected objects
                        var objectsHtml = "";
                        if (response.objects && response.objects.length > 0) {
                            response.objects.forEach(function(obj) {
                                objectsHtml += `<li class="list-group-item"><strong>${obj.object}</strong> (Confidence: ${Math.round(obj.confidence * 100)}%)</li>`;
                            });
                        } else {
                            objectsHtml = "<li class='list-group-item'>No objects detected</li>";
                        }
                        $("#objectList").html(objectsHtml);

                        // Process tags
                        var tagsHtml = "";
                        if (response.tags) {
                            response.tags.forEach(function(tag) {
                                tagsHtml += `<li class="list-group-item">${tag.name} (Confidence: ${Math.round(tag.confidence * 100)}%)</li>`;
                            });
                        }
                        $("#tagList").html(tagsHtml);

                        // Process description caption
                        if (response.description && response.description.captions.length > 0) {
                            $("#captionText").text(response.description.captions[0].text + " (Confidence: " + Math.round(response.description.captions[0].confidence * 100) + "%)");
                        } else {
                            $("#captionText").text("No description available.");
                        }
                    } else {
                        $("#result").html("<p class='text-danger'>Error: Analysis failed.</p>");
                    }
                },
                error: function(xhr) {
                    $("#result").text("Error: " + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
