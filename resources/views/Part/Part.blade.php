
@extends('layouts.main')
@section('content')
<a href="{{ action('PartController@partList')}}">List</a> 
<a href="{{ action('PartController@addPart')}}">Add</a> 
<a href="{{ action('PartController@editPart')}}">Edit</a> 
<br/>
<table id="part-list">
    <thead>
        <tr>
            <th>
                SKU
            </th>
            <th>
                description
            </th>
            <th>
                cost
            </th>
            <th>
                currency
            </th>
            <th>
                Action
            </th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection