<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

// use LivewireUI\Modal\ModalComponent;

class DeleteModal extends Component
{
    use Actions;
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
        $this->notification([
            'title'       => 'Status changed!',
            'description' => $response['message'],
            'icon'        => 'warning'
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
        if ($model == 'restaurant') {
            $this->item = $model::find($id)->title;
        } else {
            $this->item = $model::find($id)->name;
        }

        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }
}
