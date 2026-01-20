<!DOCTYPE html>
<html>


<head>
    @include('admin.css')
    <!-- Orders page styles are in public/admincss/css/custom.css -->


    
    
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
              
            <h3>All Orders</h3> 

            <br>
            <br>

            <div class="table_center orders-page">
                <div class="table-responsive w-100">
                  <table class="table orders-table table-hover align-middle mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">Customer</th>
                        <th scope="col">Address</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Image</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Status</th>
                        <th scope="col">Change Status</th>
                        <th scope="col">Print PDF</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $data)
                      <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->red_address}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->product->title}}</td>
                        <td>{{$data->product->price}}</td>
                        <td>
                          <img class="order-product-img" src="products/{{$data->product->image}}" alt="">
                        </td>
                       
                        <td>{{$data->payment_status}}</td>
                        

                        <td>
                          
                        @if($data->status == 'in progress')

                        <span style="color: orange;">{{$data->status}}</span>

                        @elseif($data->status == 'On the way')

                         <span style="color: skyblue;" >{{$data->status}}</span>

                         @else

                         <span style="color: yellow;" >{{$data->status}}</span>




                         @endif
                        <td >
                            <a  class="btn btn-primary" href="{{url('on_the_way',$data->id)}}">On the way</a>

                            <a  class="btn btn-success" href="{{url('delivered',$data->id)}}">Delivered</a>

                        </td>
                      <td>
                        <a class="btn btn-secondary"  href="{{url('print_pdf',$data->id)}}">Print PDF</a>
                      </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
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
        <script>toastr.success(@json(session('success')));</script>
    @endif
</body>

</html>