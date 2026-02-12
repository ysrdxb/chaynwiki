<?php

namespace App\Livewire\Admin;

use App\Models\Wantlist as WantlistModel;
use Livewire\Component;
use Livewire\WithPagination;

class Wantlist extends Component
{
    use WithPagination;

    public $filterStatus = 'pending';

    public function fulfill($id)
    {
        $request = WantlistModel::find($id);
        if ($request) {
            // This would normally redirect to the AI Generator with pre-filled data
            return redirect()->route('admin.articles.generate', [
                'wantlist_id' => $id,
                'topic' => $request->title,
                'category' => $request->category
            ]);
        }
    }

    public function delete($id)
    {
        $request = WantlistModel::find($id);
        if ($request) {
            $request->delete();
            session()->flash('message', 'Request removed from wantlist.');
        }
    }

    public function render()
    {
        $requests = WantlistModel::query()
            ->with(['user'])
            ->where('status', $this->filterStatus)
            ->orderBy('votes', 'desc')
            ->paginate(10);

        return view('livewire.admin.wantlist', [
            'requests' => $requests
        ])->layout('layouts.admin');
    }
}
