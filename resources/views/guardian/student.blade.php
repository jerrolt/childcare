@extends('layouts.app')

@section('content')
<guardianstudent-component :guardian_id="'{{$guardian_id}}'"></guardianstudent-component>
@endsection