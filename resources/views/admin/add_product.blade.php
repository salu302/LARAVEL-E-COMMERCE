<!DOCTYPE html>
<html>


<head>
    @include('admin.css')

    <!-- Page-specific styles moved to admin custom.css -->
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


                <h1 style="color: white;">Add Product</h1>

                @if($errors->any())
                    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                        <strong>Error:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="add-product-page">
                    <div class="form-card">
                        <form action="{{url('upload_product')}}" method="post" enctype="multipart/form-data" class="add-product-form">

                            @csrf

                            <div class="input_deg">
                                <label for="">Product Title</label>
                                <input type="text" name="title" required>
                            </div>

                            <div class="input_deg">
                                <label for=""> Description</label>
                                <textarea name="description" id="" required></textarea>
                            </div>


                            <div class="input_deg">
                                <label for="">Price</label>
                                <input type="text" name="price">
                            </div>

                            <div class="input_deg">
                                <label for="">Quantity</label>
                                <input type="number" name="quantity">
                            </div>

                            <div class="input_deg">
                                <label for="">Product Category</label>
                                <select name="category" id="" required>
                                    <option value="">Select an Option</option>
                                    @foreach($category as $category)

                                    <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input_deg">
                                <label for="">Product Image</label>
                                <input type="file" name="image" accept="image/*">
                                <small class="form-text text-muted">Max file size: 20 MB. Allowed types: jpeg, png, jpg, gif, svg.</small>
                            </div>

                            <div class="input_deg">
                                <button type="submit" class="btn btn-primary submit-btn">Add Product</button>
                            </div>
                        </form>
                    </div>
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
    <script>
        toastr.success(@json(session('success')));
    </script>
    @endif

    @if(session('error'))
    <script>
        toastr.error(@json(session('error')));
    </script>
    @endif

    <script>
        // Client-side file size check (20 MB limit) to prevent huge uploads
        (function(){
            const maxBytes = 20 * 1024 * 1024; // 20 MB
            const form = document.querySelector('.add-product-form');
            if(!form) return;
            form.addEventListener('submit', function(e){
                const fileInput = form.querySelector('input[type=file]');
                if(fileInput && fileInput.files && fileInput.files[0]){
                    if(fileInput.files[0].size > maxBytes){
                        e.preventDefault();
                        if(window.toastr){
                            toastr.error('File is too large. Maximum allowed size is 20 MB.');
                        }else{
                            alert('File is too large. Maximum allowed size is 20 MB.');
                        }
                        return false;
                    }
                }
            });
        })();
    </script>
</body>

</html>