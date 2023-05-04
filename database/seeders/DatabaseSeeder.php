<?php

namespace Database\Seeders;




// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Event;
use \App\Models\Game;
use \App\Models\Player;
use \App\Models\Team;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //userek megvannak
        $users = collect();

        $users-> add(User::factory()->create([
            'email' => 'admin@szerveroldali.hu',
            'password' => Hash::make('adminpwd'),
            'is_admin'=> true
        ]));

        for($i=1;$i<15;$i++){
            $users-> add(User::factory()->create([
                'email' => 'user' . $i . '@szerveroldali.hu',
                // 'password' => 'user'.$i
            ]));
        }

        //teammek megvannak
        $teams = collect();
        for($i=0;$i<16;$i++){
            $teams-> add(Team::factory()->create());
        }

        //teamek feltoltve jatekosokkal
        $players = collect();
        foreach ($teams as $index => $team){
            for($j=0;$j<11;$j++){
                $players->add(Player::factory()->create([
                    'team_id' => $team->id
                ]));
            }
        }


        $games = collect();
        for($i=0;$i<20;$i++){


            $randHomeTeam = $teams[rand(0,15)];
            $playersInHomeTeam = $players->where('team_id','=' , $randHomeTeam->id);
            //$this->command->info($playersInHomeTeam);

            $randAwayTeam = $teams[rand(0,15)];
            $playersInAwayTeam = $players->where('team_id','=' ,$randAwayTeam->id);

            if($randHomeTeam===$randAwayTeam){
                $i--;
            }else{
                $games->add(Game::factory()->create([
                    'hometeams_id' => $randHomeTeam,
                    'awayteams_id' => $randAwayTeam
                ]));

                $events = collect();

                $randomNumber = random_int(4, 10);
                $playersInHomeTeam = $playersInHomeTeam->random($randomNumber);
                foreach ($playersInHomeTeam as $index => $player) {
                    $randomNumEvents = random_int(1, 3);
                    for($loopCounter=0; $loopCounter<=$randomNumEvents;$loopCounter++){
                        $events->add(Event::factory()->create([
                            'player_id' => $player->id,
                            'game_id' =>$games[$i]
                        ]));
                    }
                }
                $randomNumber = random_int(4, 10);
                $playersInAwayTeam = $playersInAwayTeam->random($randomNumber);
                foreach ($playersInAwayTeam as $index => $player) {
                    $randomNumEvents = random_int(1, 3);
                    for($loopCounter=0; $loopCounter<=$randomNumEvents;$loopCounter++){
                        $events->add(Event::factory()->create([
                            'player_id' => $player->id,
                            'game_id' =>$games[$i]
                        ]));
                    }

                    //$this->command->info($playersInHomeTeam);
                }

            }

        }

        foreach($users as $index=>$user){
            //$team->users()->attach($user);

            //$user->teams()->attach(['team_id'=>$teams]);
            $teamsForUser = collect();
            foreach($teams as $index=>$team){
                $luckyNumber=rand(0,10);
                if($luckyNumber<4){
                    $teamsForUser->add($team);
                }
            }

            foreach($teamsForUser as $index=>$addTeamToUser){
                $user->teams()->attach(['team_id'=>$addTeamToUser->id]);
            }


        }
    }
}
