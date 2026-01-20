<!DOCTYPE html>
<html>


<head>
    @include('admin.css')
    <link rel="stylesheet" href="{{ asset('css/update_page.css') }}">
</head>

<body>
    <!-- header section start-->
    @include('admin.header')

    <!-- sidebar -->
    @include('admin.sidebar')

    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <h2>Update Product</h2>
                
                <div class="update-container">
                    <form class="update-form" action="{{ url('edit_product', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control" id="title" type="text" name="title" value="{{ $data->title }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description">{{ $data->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input class="form-control" id="price" type="text" name="price" value="{{ $data->price }}">
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input class="form-control" id="quantity" type="number" name="quantity" value="{{ $data->quantity }}">
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" name="category" id="category">
                                <option value="">{{ $data->category }}</option>
                                @foreach($category as $category)
                                    <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group current-image">
                            <label>Current Image</label>
                            <img src="{{ asset('products/' . $data->image) }}" alt="{{ $data->title }}">
                        </div>

                        <div class="form-group">
                            <label for="image">New Image</label>
                            <input class="form-control-file" id="image" type="file" name="image">
                        </div>

                            <div class="form-group">
                                <input class="btn btn-primary btn-block" type="submit" value="Update Product">
                            </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('admincss/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('admincss/js/front.js') }}"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if(session('success'))
        <script>toastr.success(@json(session('success')));</script>
    @endif
</body>

</html>