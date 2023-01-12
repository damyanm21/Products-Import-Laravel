@extends('layouts.app')

@section('content')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
</head>
<body>
  
<div class="container" style="margin-top: 5rem;">
    @if($message = Session::get('success'))
        <div class="alert alert-info alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <strong>Success!</strong> {{ $message }}
        </div>
    @endif

    @if($errors->any())
        <h5 style="color: red">The following errors exist in your excel file</h5>
        <ol>
          @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
          @endforeach
        </ol>
    @endif
    
    {!! Session::forget('success') !!}
    <br />
    {{--
    <a href="{{ route('exportExcel', 'xls') }}"><button class="btn btn-success">Export as xls</button></a>
    <a href="{{ route('exportExcel', 'xlsx') }}"><button class="btn btn-success">Export as xlsx</button></a>
    <a href="{{ route('exportExcel', 'csv') }}"><button class="btn btn-success">Export as csv</button></a>
    --}}
    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ route('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
      @csrf
        <input type="file" name="import_file" accept=".xlsx,.xls,.csv" required/>
        <button class="btn btn-primary">Import File</button>
    </form>
    <table class="table table-bordered mt-3">
      <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
      </tr>
       @forelse ($products as $product)
           <tr>
              <td>{{$product->name}}</td>
              <td>{{$product->description}}</td>
              <td>{{$product->price}}</td>
           </tr>
       @empty
           <td colspan="6">No imported products.</td>
       @endforelse
    </table>
</div>
   
</body>
@endsection
