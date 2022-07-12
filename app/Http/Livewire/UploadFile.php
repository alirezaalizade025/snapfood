<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadFile extends Component
{
    use WithFileUploads;

    public $photo;
    public $listeners = [
        'doUpload' => 'doUpload'
    ];

    public function save()
    {
        $this->validate([
            'photo' => 'mimes:jpg,jpeg,png|max:5120', // 5MB Max
        ]);
        $this->emit('imageUploaded', $this->photo);
    }
    public function doUpload($id)
    {
        $this->photo->storeAs('photos', now()->timestamp . '-' . $id . '.' . $this->photo->extension());
    }

    public function render()
    {
        return view('livewire.upload-file');
    }
}
