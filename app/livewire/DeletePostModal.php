<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\User;


use Illuminate\Http\Request;

class DeletePostModal extends Component
{
    public bool $showModal = false;

    public Post $post;

    

    public function delete(){
        $this->post->delete();
        return redirect()->with('message','削除しました')->route('post.index');
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function render()
    {   
        return view('livewire.delete-post-modal');
    }
}


