@extends('layouts.app')

@section('content')
<classroomstudentsadmin-component :classroom_id="{{$classroom_id}}"></classroomstudentsadmin-component>
@endsection