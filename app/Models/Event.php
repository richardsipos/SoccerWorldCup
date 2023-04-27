<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'minute',
        'player_id',
        'game_id'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function player()
    {
        return $this->belongsTo(Game::class);
    }

    public static function playersInfo($players)
    {
        $events = Event::all();
        $playersInfo = new Collection();

        foreach($players as $player){
            $sargalapok = 0;
            $piroslapok = 0;
            $golok = 0;
            $ongolok = 0;

            foreach($events as $event){

                if($event->player_id == $player->id){
                    #dd($event->type);
                    if($event->type=='öngól'){
                        $ongolok=$ongolok+1;
                    }elseif($event->type=='gól'){
                        $golok = $golok+1;
                    }elseif($event->type=='sárga lap'){
                        $sargalapok = $sargalapok+1;
                    }elseif($event->type=='piros lap'){
                        $piroslapok = $piroslapok+1;
                    }
                }

            }
            $playersInfo->push([
                'player_name' => $player->name,
                'szuletes' => $player->birthdate,
                'sargalapok' => $sargalapok,
                'piroslapok' => $piroslapok,
                'golok' => $golok,
                'ongolok' => $ongolok
            ]);
        }

        return $playersInfo;

    }
}
