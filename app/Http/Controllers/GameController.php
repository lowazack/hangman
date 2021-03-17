<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function createGame()
    {
        $user = Auth::user();

        $game = new Game();

        $word = file_get_contents("https://random-word-api.herokuapp.com/word?number=1");
        $word = str_replace('"', "", $word);
        $word = str_replace('[', "", $word);
        $word = str_replace(']', "", $word);

        $game->word = strtoupper($word);
        $game->difficulty = strlen($word);
        $game->user_id = $user->id;
        $game->save();

        return response()->json($game);
    }

    public function gameWon($gameId)
    {
        $game = Game::find($gameId);
        $user = Auth::user();

        if($game->user_id === $user->id){
            $game->hasWon = true;
            $game->save();
        }
        return response()->json($game);
    }

    public function gameLost($gameId)
    {
        $game = Game::find($gameId);
        $user = Auth::user();

        if($game->user_id === $user->id){
            $game->hasLost = true;
            $game->save();
        }
        return response()->json($game);
    }
}
