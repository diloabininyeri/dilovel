@extends('layout.master')
@section('other')
    <h2>other section</h2>
    @include('include-test')
@endsection

@section('area')
    <h2>area section test {{$name}}</h2>
@endsection
{{5+5}} <br>
{{5+1222}}<br>
@name($name)