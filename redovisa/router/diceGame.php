<?php
/**
 * Create routes using $app programming style.
 * For the guess game
 */

namespace Anax\DiceGame;

/**
 *
 * Start the game .
 *
 */
$app->router->add("diceGame/start", function () use ($app) {
  # Create a request object


     // Link for starting the game
     $aLink = "<a href='playGame' class='gameBtn'> Start game </a>";


    // Setting the content to send to the view
    $title = "Test";
    $data = [
        "class" => "theDiceGame",
        "gameHeader" => "<h1>The dice game</h1>",
        "players" => " Ready?",
        "content" => "<h2> Let the game begin! </h2> \n Lets play? \n".$aLink,
    ];


    // Adding the view and including the content
    $app->page->add("anax/diceGame/diceGame", $data);


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
$app->router->add("diceGame/playGame", function () use ($app) {


      // Set up
      $title = "The dice game";

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

    if ($app->session->has("theDiceGame")) {
        # Get game session
        $theGame = unserialize($app->session->get("theDiceGame"));
        $res1 = "Game collected from session";
        $res = $theGame->playGame();

        # Print the players score
        $thePlayersRes = $theGame->getPlayersScore();

        # Save the session
        $app->session->set("theDiceGame", serialize($theGame));
    } else {
        # Start a new game
        $res1 = "New game session: " . strval(rand());
        $theGame = new TheGame($nrDice, $playerArr);

        # Create a first player & play
        $firstPlayer = $theGame->getFirstPlayer();
        $res = $theGame->playGame($firstPlayer);

        # Save the game obj to the session
        $app->session->set("theDiceGame", serialize($theGame));

        # Print the players score
        $thePlayersRes = $theGame->getPlayersScore();
    }


    $restartForm = "<button class='gameBtn'> <a href='reset'> New game </a> </button>";

    // Setting the content for the view
    $data = [
        "class" => "TheDiceGame",
        "gameHeader" => "<h1>The dice game </h1>",
        "players" => "<h3> The players </h3>".$thePlayersRes,
        "content" => $res."</br>".$restartForm,
    ];

    // Adding the content to the view
    $app->page->add("anax/diceGame/diceGame", $data);


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

  $app->router->add("diceGame/reset", function () use ($app) {


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
          "class" => "TheDiceGame",
          "gameHeader" => "<h1>The guess game</h1>",
          "players" => "<img src='../img/dice.jpg' alt='dice' width=200>",
          "content" => "<h1> Game reset </h1> \n Lets play again? \n".$aLink,
      ];

      // Adding the view
      $app->page->add("anax/diceGame/diceGame", $data);


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
  $app->router->add("diceGame/playAgain", function () use ($app) {

    /**
     * Catch the user/computers choice
     * Play again or register points
     *
     * Get the game object from the session & register the necessary
     *
     */

    if ($app->session->has("theDiceGame")) {
        # Get game session
        $theGame = unserialize($app->session->get("theDiceGame"));

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

          $reply .= "<a href='playGame' class='gameBtn'> Ok </a>";

        # Save the game session
        $app->session->set("theDiceGame", serialize($theGame));
    }

        $title = "DiceGame";

        // Setting the content for the view
        $data = [
            "class" => "TheDiceGame",
            "gameHeader" => "<h1>The dice game </h1>",
            "players" => "<img src='../img/dice.jpg' alt='dice' width=300> <br/>",
            "content" => $reply,
        ];

        // Adding the content to the view
        $app->page->add("anax/diceGame/diceGame", $data);


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
        $app->router->add("diceGame/nextPlayer", function () use ($app) {

          /**
           * Catch the user/computers choice
           * Play again or register points
           *
           * Get the game object from the session & register the necessary
           *
           */

            // Use the game object & change the player to next one
            if ($app->session->has("theDiceGame")) {
                # Get game session
                $theGame = unserialize($app->session->get("theDiceGame"));

                # Change player to next
                $theGame->nextPlayer();

                # Get current player
                $nextPlayer = $theGame->getCurrentPlayer();

                # Report which player is next
                $reply = $nextPlayer->getName();

                # Save the changes
                $app->session->set("theDiceGame", serialize($theGame));
            }

              $reply .= "<a href='playGame' class='gameBtn'> Ok </a>";

              # Save the game session
              $app->session->set("theDiceGame", serialize($theGame));


              $title = "DiceGame";

              // Setting the content for the view
              $data = [
                  "class" => "TheDiceGame",
                  "gameHeader" => "<h1>The dice game </h1>",
                  "players" => " Next player! <br/>" ,
                  "content" => $reply,
              ];

              // Adding the content to the view
              $app->page->add("anax/diceGame/diceGame", $data);


              // Returning the total
              return $app->page->render([
                  "title" => $title,
              ]);
        });
