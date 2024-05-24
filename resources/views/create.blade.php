@extends('components.layout')

@section('title', 'Register')

@section('content')
<form action="{{route('categories.items.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <x-input name="name" type="text" label="name"/>
    <x-input name="description" type="text" label="description"/>
    <x-input name="category_id" type="number" label="Category"/>
    <x-input name="price" type="number" label="price"/>
    <input type="file" name="imageURL" class="bg-blue-600" accept="image/*">
    <button type="submit">Submit</button>
</form>
@endsection