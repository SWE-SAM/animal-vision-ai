<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azure AI Image Analyzer</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Upload an Image for Analysis</h2>
    
    <form id="imageUploadForm" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" id="imageInput" required>
        <button type="submit">Analyze Image</button>
    </form>

    <h3>Analysis Result:</h3>
    <pre id="result"></pre>

    <script>
        $(document).ready(function(){
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
</body>
</html>
