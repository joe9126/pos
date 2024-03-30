@extends('layouts.app')
@section('content')
    <p>test</p>

    <div class="container">

    {{ $dataTable->table() }}
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush