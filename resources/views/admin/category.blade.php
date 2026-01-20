<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style type="text/css">
        input[type=text] {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
        }

        .dev_deg {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .table_deg {
            margin-top: 50;
            border: 2px solid yellowgreen;
            width: 70%;
            margin: 50px auto;
            text-align: center;
        }

        th {
            background: skyblue;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }

        td {
            padding: 15px;
            font-size: 18px;
            color: white;
            border: 1px solid skyblue;
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

                <div>

                    <h1 style="color: white;">Add Category</h1>


                    <div class="dev_deg"></div>

                    <form action="{{url('add_category')}}" method="post">
                        @csrf

                        <div>
                            <input type="text" name="category">

                            <input class="btn btn-primary" type="submit" value="Add Category">
                        </div>
                    </form>
                </div>

                <div>
                    <table class="table_deg">
                        <tr>
                            <th>Category Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        @foreach($data as $data)
                        <tr>
                            <td>{{$data->category_name}}</td>
                            <td>
                                <a class="btn btn-success" href="{{url('edit_category',$data->id)}}">Edit</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" onclick="confirmation(event)" href="{{url('delete_category',$data->id)}}">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>



            </div>
        </div>
    </div>
    <!-- JavaScript files-->


    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.
            getAttribute('href');

            console.log(urlToRedirect);
            swal({
                    title: "Are you sure to delete this category?",
                    text: "This will delete the category permanently!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        window.location.href = urlToRedirect
                    }
                });
        }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



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
</body>

</html>