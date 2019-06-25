@extends('layouts.app')

@section('content')
<dashboardguardian-component :guardian_id="{{$guardian_id}}"></dashboardguardian-component>
@endsection
