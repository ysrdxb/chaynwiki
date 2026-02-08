@extends('layouts.wiki')

@section('title', $user->name . ' - ChaynWiki')

@section('content')
    <livewire:user-profile :user="$user" />
@endsection
