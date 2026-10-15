<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event
        </h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">

        <form action="{{ route('event.admin.update', ['event' => $event->id]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Event</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $event->title) }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori</label>

                <select name="category" class="w-full border rounded p-2" required>
                    <option value="Musik" {{ old('category', $event->category) == 'Musik' ? 'selected' : '' }}>
                        Musik
                    </option>

                    <option value="Festival" {{ old('category', $event->category) == 'Festival' ? 'selected' : '' }}>
                        Festival
                    </option>

                    <option value="Seminar" {{ old('category', $event->category) == 'Seminar' ? 'selected' : '' }}>
                        Seminar
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Harga (Rp)</label>

                <input
                    type="number"
                    name="ticket_price"
                    value="{{ old('ticket_price', $event->ticket_price) }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>

                <textarea
                    name="description"
                    class="w-full border rounded p-2"
                    rows="3"
                    required
                >{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">
                    Gambar Poster Event
                </label>

                @if($event->Image)
                    <div class="mb-2">
                        <img
                            src="{{ asset('storage/' . $event->Image) }}"
                            class="w-32 h-32 object-cover rounded"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    name="image"
                    class="w-full border rounded p-2"
                >

                <p class="text-sm text-gray-500 mt-1">
                    Kosongkan jika tidak ingin mengganti gambar.
                </p>
            </div>

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded font-semibold"
                >
                    Update Data
                </button>

                <a
                    href="{{ route('event.admin.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded font-semibold"
                >
                    Batal
                </a>
            </div>

        </form>
    </div>
</x-app-layout>