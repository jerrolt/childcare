@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Guardian Registration</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
						
						<div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="firstname" class="col-md-4 control-label">Firstname</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required autofocus>

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <!--
						<div class="form-group{{ $errors->has('mi') ? ' has-error' : '' }}">
                            <label for="mi" class="col-md-4 control-label">MI</label>

                            <div class="col-md-2">
                                <input id="mi" type="text" class="form-control" name="mi" value="{{ old('mi') }}" maxlength="1" autofocus>

                                @if ($errors->has('mi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mi') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        -->
                        
                        
						<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label">Lastname</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



						<!-- new phone/account_number number required -->
						<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="(XXX) XXX-XXXX" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<!-- end phone input -->

	                  
<!-- Mobile Phone - carrier_id select -->	                   
<div class="form-group{{ $errors->has('carrier') ? ' has-error' : '' }}">
	<label for="carrier_id" class="col-md-4 control-label">Mobile Carrier</label>	
	<div class="col-md-6">
		<select class="form-control" id="carrier_id" name="carrier_id">
			<option selected disabled hidden value="">Select a Mobile Carrier</option>
			@foreach($carriers as $carrier)
				<option value="{{ $carrier->id }}">{{ ucfirst($carrier->name) }}</option>
			@endforeach
		</select>
		@if ($errors->has('carrier'))
            <span class="help-block">
                <strong>{{ $errors->first('carrier') }}</strong>
            </span>
        @endif
	</div>
</div>
<!-- End Carrier input -->





                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
