@extends('layouts.app')

@section('content')
<guardianstudentsadmin-component :guardian_id="{{$guardian_id}}"></guardianstudentsadmin-component>
@endsection