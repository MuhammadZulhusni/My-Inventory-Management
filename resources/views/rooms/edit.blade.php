@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Room</h1>

    <form action="{{ route('rooms.update', $room) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Room Name</label>
            <input type="text" name="name" value="{{ old('name', $room->name) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block">Location</label>
            <input type="text" name="location" value="{{ old('location', $room->location) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block">Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" class="w-full border rounded p-2" required min="1">
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('rooms.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
        </div>
    </form>
</div>
@endsection
