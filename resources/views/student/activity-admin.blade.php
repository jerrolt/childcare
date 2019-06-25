@extends('layouts.app')

@section('content')
<activityadmin-component user_id="<?= Auth::user()->id ?>" start="<?= date('Y-m-d', strtotime('7 days ago')) ?>" end="<?= date('Y-m-d', strtotime('yesterday')) ?>"></activityadmin-component>
@endsection