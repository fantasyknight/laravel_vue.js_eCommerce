<!DOCTYPE html>
<html>
<head></head>
<body>
    <div class="container">
        <form action="{{ route('resizeImagePost') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <input type="file" name="file" />
                <button type="submit">Upload Image</button>
            </div>
        </form>
    </div>
</body>
</html>