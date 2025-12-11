@extends('layout.master')
@section('title', 'Brand Management')
@section('content')
    <div class="grid grid-cols-3 gap-10">
        <div class="col-span-1">
            <p class="text-xl mb-3">Add Brand</p>
            <livewire:form-create-brand />
        </div>
        <div class="col-span-2">
            <p class="text-xl mb-3">Brand Table</p>
            <livewire:table-brand />
        </div>
    </div>
@endsection
