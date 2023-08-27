@extends('templates.administration')

@section('content')
    @livewire('admin.report.create', ['halls' => $halls])
@endsection

@section('scripts')
    @livewireChartsScripts
@endsection
