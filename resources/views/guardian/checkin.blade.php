@extends($layout)


@section('content')
<guardianscheckin-component :guardian_id="{{$guardian_id}}" role="{{$role}}"></guardianscheckin-component>
@endsection