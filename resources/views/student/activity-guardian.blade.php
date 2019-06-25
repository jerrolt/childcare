@extends('layouts.app')

@section('content')
<activityguardian-component :guardian_id="{{$guardian_id}}" start="<?= date('Y-m-d', strtotime('7 days ago')) ?>" end="<?= date('Y-m-d', strtotime('yesterday')) ?>"></activityguardian-component>
@endsection