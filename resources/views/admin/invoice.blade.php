<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>




    <center>
        <h3>Customer name : {{$data->name}}</h3>

        <h3>Customer address : {{$data->red_address}}</h3>

        <h3>Customer phone : {{$data->phone}}</h3>

       <h2>Product Title :{{$data->product->title}}</h2>
       
       <h2>Product Price :{{$data->product->price}}</h2>

       @if(!empty($data->product->image) && file_exists(public_path('products/'.$data->product->image)))
            @php
                $path = public_path('products/'.$data->product->image);
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $dataImage = base64_encode(file_get_contents($path));
                $src = 'data:image/' . $type . ';base64,' . $dataImage;
            @endphp
            <img height="250" width="300" src="{{ $src }}" alt="">
       @endif

    </center>

     
</body>
</html>