<!DOCTYPE html>
<html>


<head>
    @include('admin.css')
    <link rel="stylesheet" href="{{ asset('css/view_product.css') }}">

    <style>

        /* css for search is ko baad may add karna hay us may . */
        input[type='search']{
            width: 500px;
            height: 60px;
            margin-left: 50px;
        }
    </style>
    
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



            <form action="{{ url('product_search') }}" method="get" class="search-form">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-control" style="display:inline-block; width:420px;">
                <input class="btn btn-secondary" type="submit" value="Search">
            </form> 

              <div class="div_deg">
                <table class="table_deg">
                    <tr>
                        <th>Product Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        

                    </tr>

                    @if($product->count())
                        @foreach($product as $products)

                        <tr>
                            <td>{{ $products->title }}</td>
                            <td>{!! Str::limit($products->description, 50) !!}</td>
                            <td>{{ $products->category }}</td>
                            <td>{{ $products->price }}</td>
                            <td>{{ $products->quantity }}</td>
                            <td>
                                <img src="products/{{ $products->image }}" width="200px" height="200px">
                            </td>

                            <td>
                                <a class="btn btn-success" href="{{ url('update_product', $products->slug) }}">Edit</a>
                            </td>

                            <td>
                                <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this product?')" href="{{ url('delete_product', $products->id) }}">Delete</a>
                            </td>
                        </tr>

                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">No products found for "{{ request('search') }}"</td>
                        </tr>
                    @endif
                    

                </table>
              </div>
             <div> {{$product->onEachSide(1)->links()}}</div>

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