<?php

namespace App\Http\Livewire;

use App\Models\Card;
use App\Models\Group;
use Livewire\Component;

class Trello extends Component
{
    public bool $addGroupState = false;
    public string $addCardState = "";
    public string $title = "";

    public function createGroup($group_id){
        $this->addGroupState = true;
    }

    public function createCard($group_id)
    {
        $this->addCardState = $group_id;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
        ];
    }
    public function save(){
        $this->validate();
        if ($this->addGroupState){
            Group::create([
                'title'=>$this->title
            ]);
        } else {
            Card::create([
                'title'=>$this->title,
                'group_id' =>$this->addCardState,
            ]);
        }

        $this->res();
    }

    public function res(){
        $this->addCardState = "";
        $this->addGroupState = false;
        $this->title = "";
    }
    public function updateGroup($values)
    {
        foreach ($values as $value){
            Group::where('id',$value['value'])->update(['sort'=>$value['order']]);
        }
    }

    public function updateCard($values)
    {
        foreach ($values as $value){
            //Group::where('id',$value['value'])->update(['sort'=>$value['order']]);
            foreach ($value['items'] as $item){
                Card::where('id', $item['value'])->update(['sort'=>$item['order']
                    , 'group_id'=>$value['value']
                ]);
            }
        }
    }

    public function deleteCard($card_id)
    {
        Card::destroy($card_id);
    }

    public function deleteGroup($group_id)
    {
        Group::destroy($group_id);
    }
    public function render()
    {
        $groups = Group::orderBy('sort')->get();
        return view('livewire.trello',['groups'=>$groups]);
    }
}
