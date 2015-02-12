
@extends('layouts.main')
@section('content')
<a href="{{ action('PartController@partList')}}">List</a> 
<a href="{{ action('PartController@addPart')}}">Add</a> 
<a href="{{ action('PartController@editPart')}}">Edit</a> 
<br/>
@foreach ($partlist as $value) 
{{ $value->SKU }}
{{ $value->description }}
{{ $value->cost }}
{{ $value->currency }}
@if (isset($value->id))
    <a id="edit" href="{{ action('PartController@editPart')}}/{{$value->id}}">edit</a> 
@endif
<br/>
@endforeach

@endsection