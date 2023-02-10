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

    @if($errors instanceof Illuminate\Support\Collection && $errors->any())
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
        <input type="file" name="import_file" accept=".xlsx,.xls,.csv,.ods" required/>
        <button class="btn btn-primary">Import File</button>
    </form>
    <table class="table table-bordered mt-3">
      @if(isset($created))
      <tr>
        <td> </td>
      </tr>
      <tr style="background-color:#c3dffa; border: 4px solid #fff242">
            <td class="mb-2">Import Results:</td>
            <td class="mb-3">Created: {{ $created }}</td>
            <td class="mb-3">Failed: {{ $failed }}</td>
      </tr>
      <tr>
        <td> </td>
      </tr>
      @endif
      <tr>
          <th>Sku</th>
          <th>Name</th>
          <th>Price</th>
      </tr>
       @php 
       $lastimportid = 0;
       @endphp
       @forelse ($products as $product)
            @if($lastimportid!=$product->importid)
            <tr style="background-color:#c3dffa; border:solid lightgrey">
              <td>
                {{$product->created_at}}
              </td>
              <td>
              </td>
              <td>
                <form action="{{ route('importMagento') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="imported" value="{{ $product->importid }}"/>
                <button class="btn">Export to Magento</button>
                </form>
              </td>
            </tr>
            @php 
              $lastimportid=$product->importid;
            @endphp
            @endif
            @if($product->imported==-1)
            <tr style="background-color:#f5c6c680">
            @elseif($product->imported==1)
            <tr style="background-color:#d7f5bc80">
            @else
            <tr style="background-color:white">
            @endif
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
