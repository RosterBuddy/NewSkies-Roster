@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update {{$user->name}}s profile</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.update_user_profile', $user->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" value="{{$user->name}}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" value="{{$user->email}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--Insert Team Logic Here-->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Select Team') }}</label>
                            <div class="col-md-6">
                                <select name="team" id="team">
                                    <option value="{{$user->team_id}}">{{$user->team->team_name}}</option>
                                    @foreach ($teams as $team)
                                        @if($team->id != $user->team_id)
                                            <option value="{{$team->id}}">{{$team->team_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--Insert isAdmin Here-->
                        <div class="form-group row">
                            <label for="isAdmin" class="col-md-4 col-form-label text-md-right">{{ __('Is user a Teamlead?') }}</label>
                            <div class="col-md-6">
                                <select name="isAdmin" id="isAdmin">
                                    @if($user->isAdmin == 1)
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    @elseif($user->isAdmin == 0)
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="isTerminated" class="col-md-4 col-form-label text-md-right">{{ __('Terminate User?') }}</label>
                            <div class="col-md-6">
                                <select name="isTerminated" id="isTerminated">
                                    @if($user->isTerminated == 1)
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    @elseif($user->isTerminated == 0)
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update User') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-4 text-md-right">Created At:</label>
                        <div class="col-md-4">
                            {{\Carbon\Carbon::createFromTimestamp(strtotime($user->created_at))->format('H:i d/m/Y')}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 text-md-right">Updated At:</label>
                        <div class="col-md-4">
                            {{\Carbon\Carbon::createFromTimestamp(strtotime($user->updated_at))->format('H:i d/m/Y')}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 text-md-right">Verified At:</label>
                        <div class="col-md-4">
                            {{\Carbon\Carbon::createFromTimestamp(strtotime($user->email_verified_at))->format('H:i d/m/Y')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
