@extends('layouts.app')
@section('content')
<button type="button" onClick="window.location.reload();">Generate New Password</button>
<br>
<br>
<H2>New Password: <span style="color:red;">{{$str}}</span></H2>
@endsection