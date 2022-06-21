<?php

namespace App\Http\Livewire;

use Livewire\Component;
// use LivewireUI\Modal\ModalComponent;

class DeleteModal extends Component
{
    public $showingModal = false;
    public $title = 'Delete item';
    public $selectID;
    public $model;
    public $item;

    public $listeners = [
        'hideMe' => 'hideModal',
        'showDeleteModal' => 'showModal'
    ];


    public function deleteItem()
    {
        $response = app("App\Http\Controllers\\$this->model" . 'Controller')->destroy($this->selectID);
        $response = json_decode($response, true);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        $this->showingModal = false;
        $this->emit('refresh' . $this->model . 'Table');
    }

    public function render()
    {
        return view('livewire.delete-modal');
    }

    public function showModal($model, $id)
    {
        $this->selectID = $id;
        $this->model = $model;
        $model = "App\Models\\" . $model;
        $this->item = $model::find($id)->name;

        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }
}
