@extends('layout.master')
@section('title', 'Product Management')
@section('content')
    <div class="grid grid-cols-3 gap-10">
        <div class="col-span-1">
            <p class="text-xl mb-3">Add Product</p>
            <livewire:form-create-product />
        </div>
        <div class="col-span-2">
            <p class="text-xl mb-3">Product Table</p>
            <livewire:table-product />
        </div>
    </div>
@endsection
