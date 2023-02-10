@extends('layouts.app')

@section('content')



<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
</head>
<body>
   <form action="/test" method="GET">
       <label for="sku">Sku:</label>
       <input type="text" id="sku" name="sku">
       <label for="name">Name:</label>
       <input type="text" id="name" name="name">
       <input type="submit">
   </form>
</body>
@endsection