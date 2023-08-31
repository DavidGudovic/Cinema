@extends('templates.administration')

@section('content')
    @livewire('admin.report.index', ['halls' => $halls, 'managers' => $managers])
@endsection

