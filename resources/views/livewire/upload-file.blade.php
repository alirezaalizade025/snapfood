<div>
    <label class="font-medium text-white flex justify-between mb-1">
        <span>Image</span>
        @if ($photo)
            <span class="bg-blue-400 rounded-xl p-1 cursor-pointer" wire:click="save">Save</span>
            <span class="bg-red-400 rounded-xl p-1 cursor-pointer" wire:click="$set('photo', null)">Remove</span>
        @endif
    </label>
    @if ($photo)
        <img src="{{ $photo->temporaryUrl() }}" class="object-cover w-72 h-40 rounded-lg">
    @else
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48"
                    aria-hidden="true">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                    <label for="file-upload"
                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <span class="">Upload a file</span>
                        <input type="file" wire:model="photo" id="file-upload" name="file-upload" class="sr-only">
                    </label>
                    <p class="pl-1 text-white">or drag and drop</p>
                </div>
                <p class="text-xs text-white">
                    PNG, JPG, GIF up to 5MB
                </p>
            </div>
        </div>
        <div wire:loading wire:target="photo">Uploading...</div>
        @error('photo')
            <span class="error">{{ $message }}</span>
        @enderror
    @endif
    {{-- <input type="file" wire:model="photo">

    @error('photo')
        <span class="error">{{ $message }}</span>
    @enderror

    <button wire:click="save">Save Photo</button> --}}

</div>
