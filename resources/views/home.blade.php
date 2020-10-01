@extends('layouts.app')

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

@section('content')
<div id="app">
    <chat-app :user="{{ auth()->user() }}" :url="'{{ url('/') }}'" />
</div>
@endsection
