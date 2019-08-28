<?php
/**
 * Create routes using $app programming style.
 * For the guess game
 */

namespace Anax\DiceGame2;

/**
 *
 * Start the game .
 *
 */
$app->router->add("diceGame2/start", function () use ($app) {
  # Create a request object


     // Link for starting the game
     $aLink = "<a href='playGame'> Start game </a>";


    // Setting the content to send to the view
    $title = "Test";
    $data = [
        "class" => "theDiceGame2",
        "gameHeader" => "<h1>The dice game v2</h1>",
        "histogram" => "",
        "players" => " Ready?",
        "content" => "<h2> Let the game begin! </h2> \n Lets play? \n".$aLink,
    ];


    // Adding the view and including the content
    $app->page->add("anax/diceGame2/diceGame2", $data);


    // Returning the total
    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 *
 * Play the game
 *
 */
$app->router->add("diceGame2/playGame", function () use ($app) {


      // Set up
      $title = "The dice game, vers 2";

      // Add the players
      $aPlayer = new Player();
      $aPlayer->setName('You');
      $aPlayer->setIsHuman(true);

      $aPlayer2 = new Player();
      $aPlayer2->setName('Computer');

      $playerArr = [$aPlayer, $aPlayer2];

      // Nr dice
      $nrDice = 5;


    // --- Get current game from session or start a new one ---

    if ($app->session->has("theDiceGame2")) {
        # Get game session
        $theGame = unserialize($app->session->get("theDiceGame2"));
        $res1 = "Game collected from session";
        $res = $theGame->playGame();

        # Print the players score
        $thePlayersRes = $theGame->getPlayersScore();

        # Print the histogram
        $histogram = $theGame->getHistogram();

        # Print the statistics
        $statistics = $theGame->getStatistics();

        # Save the session
        $app->session->set("theDiceGame2", serialize($theGame));
    } else {
        # Start a new game
        $res1 = "New game session: " . strval(rand());
        $theGame = new TheGame($nrDice, $playerArr);

        # Create a first player & play
        $firstPlayer = $theGame->getFirstPlayer();
        $res = $theGame->playGame($firstPlayer);

        # Save the game obj to the session
        $app->session->set("theDiceGame2", serialize($theGame));

        # Print the players score
        $thePlayersRes = $theGame->getPlayersScore();

        # Print the histogram
        $histogram = $theGame->getHistogram();

        # Print the statistics
        $statistics = $theGame->getStatistics();

    }


    $restartForm = "<button class='gameBtn'> <a href='reset'> New game </a> </button>";

    // Setting the content for the view
    $data = [
        "class" => "TheDiceGame2",
        "gameHeader" => "<h1>The dice game2 </h1>",
        "histogram" => "<h3> Histogram </h3>".$histogram."<br/>".$statistics."<br/>",
        "players" => "<h3> The players </h3>".$thePlayersRes,
        "content" => $res."</br>".$restartForm,
    ];

    // Adding the content to the view
    $app->page->add("anax/diceGame2/diceGame2", $data);


    // Returning the total
    return $app->page->render([
        "title" => $title,
    ]);
});



  /**
   *
   * Play the game
   *
   */

  $app->router->add("diceGame2/reset", function () use ($app) {


       // Unset all of the session variables.
       $_SESSION = [];

       // If it's desired to kill the session, also delete the session cookie.
       // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
           $params = session_get_cookie_params();

           setcookie(
               session_name(),
               '',
               time() - 42000,
               $params["path"],
               $params["domain"],
               $params["secure"],
               $params["httponly"]
           );
    }

       // Finally, destroy the session.
       $app->session->destroy();

       $aLink = "<a href='playGame' class='gameBtn'> Yeah </a>";

      // Getting the content
      $title = "Reset";
      $data = [
          "class" => "TheDiceGame2",
          "gameHeader" => "<h1>The guess game</h1>",
          "histogram" => "",
          "players" => "<img src='../img/dice.jpg' alt='dice' width=200>",
          "content" => "<h1> Game reset </h1> \n Lets play again? \n".$aLink,
      ];

      // Adding the view
      $app->page->add("anax/diceGame2/diceGame2", $data);


      // Returning the info
      return $app->page->render([
          "title" => $title,
      ]);
  });



  /**
   *
   * Play the game again
   *
   */
  $app->router->add("diceGame2/playAgain", function () use ($app) {

    /**
     * Catch the user/computers choice
     * Play again or register points
     *
     * Get the game object from the session & register the necessary
     *
     */

    if ($app->session->has("theDiceGame2")) {
        # Get game session
        $theGame = unserialize($app->session->get("theDiceGame2"));

        # Get the form arguments
        # If more games are requested, register that in object
        # Save the object in the session
        $playAgain = $app->request->getGet('play');

        if ($playAgain == 'yes') {
            # Set up the object to play again
            $res = $theGame->setPlayAgain();
            $reply = "Play again !";
        } else {
            # Collect points & next player
            $res = $theGame->collectPoints();
            $theGame->nextPlayer();
            $reply = "Collecting the points.";
        }

          $reply .= "<a href='playGame'> Ok </a>";

        # Save the game session
        $app->session->set("theDiceGame2", serialize($theGame));
    }   else {
      $reply = "Session not found";
    }

        $title = "DiceGame";

        // Setting the content for the view
        $data = [
            "class" => "TheDiceGame2",
            "gameHeader" => "<h1>The dice game </h1>",
            "histogram" => "",
            "players" => "<img src='../img/dice.jpg' alt='dice' width=300> <br/>",
            "content" => $reply,
        ];

        // Adding the content to the view
        $app->page->add("anax/diceGame2/diceGame2", $data);


        // Returning the total
        return $app->page->render([
            "title" => $title,
        ]);
  });




        /**
         *
         * Next player
         *
         */
        $app->router->add("diceGame2/nextPlayer", function () use ($app) {

          /**
           * Catch the user/computers choice
           * Play again or register points
           *
           * Get the game object from the session & register the necessary
           *
           */

            // Use the game object & change the player to next one
            if ($app->session->has("theDiceGame2")) {
                # Get game session
                $theGame = unserialize($app->session->get("theDiceGame2"));

                # Change player to next
                $theGame->nextPlayer();

                # Get current player
                $nextPlayer = $theGame->getCurrentPlayer();

                # Report which player is next
                $reply = $nextPlayer->getName();

                # Save the changes
                $app->session->set("theDiceGame2", serialize($theGame));
            }

              $reply .= "<a href='playGame' class='gameBtn'> Ok </a>";

              # Save the game session
              $app->session->set("theDiceGame2", serialize($theGame));


              $title = "DiceGame2";

              // Setting the content for the view
              $data = [
                  "class" => "TheDiceGame2",
                  "gameHeader" => "<h1>The dice game 2 </h1>",
                  "histogram" => "",
                  "players" => " Next player! <br/><br/>" ,
                  "content" => $reply,
              ];

              // Adding the content to the view
              $app->page->add("anax/diceGame2/diceGame2", $data);


              // Returning the total
              return $app->page->render([
                  "title" => $title,
              ]);
        });
