<?php

class Player
{

   public $name;
   public $coins;

   public function __construct($name, $coins)
   {
      $this->name = $name;
      $this->coins = $coins;
   }

   public function point(Player $player)
   {

      $this->coins++;
      $player->coins--;
   }

   public function bancrot()
   {

      return $this->coins == 0;
   }

   public function bank()
   {

      return $this->coins;
   }

   public function odds(Player $player)
   {

      return round($this->bank() / ($this->bank() + $player->bank()) * 100, 2) . "%";
   }
}


class Game
{

   protected $player1;
   protected $player2;
   protected $flips = 1;

   public function __construct(Player $player1, Player $player2)
   {
      $this->player1 = $player1;
      $this->player2 = $player2;
   }

   public function flip()
   {
      //Подбросить монету
      return rand(0, 1) ? "орёл" : "решка";
   }

   public function start()
   {

      echo $this->player1->name . ": шансы " . $this->player1->odds($this->player2) . "<br>";
      echo $this->player2->name . ": шансы " . $this->player2->odds($this->player1) . "<br>";

      $this->play();
   }


   public function play()
   {

      while (true) {

         //Если Орёл, п1 получает монету ,п2 теряет
         //Если Решка п2 получает ,п1 теряет
         if ($this->flip() == "орёл") {

            $this->player1->point($this->player2);
         } else {

            $this->player2->point($this->player1);
         }

         //если у кого то количество монет  будет 0 то игра кончается
         if ($this->player1->bancrot() || $this->player2->bancrot()) {
            return $this->end();
         }

         $this->flips++;
      }
   }

   public function end()
   {
      //побеждает тот у кого больше монет
      echo "Game over" . "<br>";

      echo $this->player1->name . " :" . $this->player1->bank() . "<br>";
      echo $this->player2->name . " :" . $this->player2->bank() . "<br>";

      echo "Winner - " . $this->winner()->name . "<br>";
      echo "Количество подбрасываний " . $this->flips . "<br>";
   }

   public function winner(): Player
   {

      return $this->player1->bank() > $this->player2->bank() ? $this->player1 :  $this->player2;
   }
}



$game = new Game(

   new Player("casino", 10000),
   new Player("Jane", 100)

);




$game->start();
