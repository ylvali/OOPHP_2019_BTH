<?php

namespace Anax\DiceGame2;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class AppController implements AppInjectableInterface
{
    use AppInjectableTrait;
    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";
    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
        // Use $this->app to access the framework services.
    }
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }
    /**
     * This sample method dumps the content of $app.
     * GET mountpoint/dump-app
     *
     * @return string
     */
    public function dumpAppActionGet() : string
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->app->getServices());
        return __METHOD__ . "<p>\$app contains: $services";
    }
    /**
     * Add the request method to the method name to limit what request methods
     * the handler supports.
     * GET mountpoint/info
     *
     * @return string
     */
    public function infoActionGet() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }
    /**
     * This sample method action it the handler for route:
     * GET mountpoint/create
     *
     * @return string
     */
    public function createActionGet() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }
    /**
     * This sample method action it the handler for route:
     * POST mountpoint/create
     *
     * @return string
     */
    public function createActionPost() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }
    /**
     * This sample method action takes one argument:
     * GET mountpoint/argument/<value>
     *
     * @param mixed $value
     *
     * @return string
     */
    public function argumentActionGet($value) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }
    /**
     * This sample method action takes zero or one argument and you can use - as a separator which will then be removed:
     * GET mountpoint/defaultargument/
     * GET mountpoint/defaultargument/<value>
     * GET mountpoint/default-argument/
     * GET mountpoint/default-argument/<value>
     *
     * @param mixed $value with a default string.
     *
     * @return string
     */
    public function defaultArgumentActionGet($value = "default") : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }
    /**
     * This sample method action takes two typed arguments:
     * GET mountpoint/typed-argument/<string>/<int>
     *
     * NOTE. Its recommended to not use int as type since it will still
     * accept numbers such as 2hundred givving a PHP NOTICE. So, its better to
     * deal with type check within the action method and throuw exceptions
     * when the expected type is not met.
     *
     * @param mixed $value with a default string.
     *
     * @return string
     */
    public function typedArgumentActionGet(string $str, int $int) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got string argument '$str' and int argument '$int'.";
    }
    /**
     * This sample method action takes a variadic list of arguments:
     * GET mountpoint/variadic/
     * GET mountpoint/variadic/<value>
     * GET mountpoint/variadic/<value>/<value>
     * GET mountpoint/variadic/<value>/<value>/<value>
     * etc.
     *
     * @param array $value as a variadic parameter.
     *
     * @return string
     */
    public function variadicActionGet(...$value) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value);
    }
    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
        // Deal with the request and send an actual response, or not.
        //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
        return;
    }


    /* METHODS FOR THE DICE GAME 2 */

    /**
     *
     * Start the game
     *
     * @return object
     */
    public function startAction() : object
    {
          // Link for starting the game
          $aLink = "<a href='playGame'> Start game </a>";

          $info = " The computer makes decisions if to continue playing based on the probability of winning & ";
          $info .= " how many rounds have been won so far. If the current % of won games is below ";
          $info .= " what is probable, the computer will keep on playing one time.<br/><br/>";
          $info .= " The probability is calculated by 1 - ((5/6) ^ nr dice)<br/><br/>";
          $info .= " When more rounds have been played, the computer gets braver and plays on a higher % than the probability.";


         // Setting the content to send to the view
         $title = "Test";
         $data = [
             "class" => "theDiceGame2",
             "gameHeader" => "<h1>The dice game v2</h1>",
             "histogram" => $info ."<br/>",
             "players" => " Ready?",
             "content" => "<h2> Let the game begin! </h2> \n Lets play? \n".$aLink,
         ];


         // Adding the view and including the content
         $this->app->page->add("anax/diceGame2/diceGame2", $data);


         // Returning the total
         return $this->app->page->render([
             "title" => $title,
         ]);
    }


    /**
    *
    * Play game
    *
    * @return object
    *
    */
    public function playGameAction() : object
    {
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

        if ($this->app->session->has("theDiceGame2")) {
            # Get game session
            $theGame = unserialize($this->app->session->get("theDiceGame2"));
            $res1 = "Game collected from session";
            $res = $theGame->playGame();

            # Print the players score
            $thePlayersRes = $theGame->getPlayersScore();

            # Print the histogram of a the current round
            $histogram = $theGame->getHistogram();

            # Create the histogram for the whole game
            $aHistogram = new Histogram();
            $aHistogram->injectData($theGame);
            $wholeGameHistogram = $aHistogram->getAsText();

            # Print the statistics
            $statistics = $theGame->getStatistics();

            # Save the session
            $this->app->session->set("theDiceGame2", serialize($theGame));
        } else {
            # Start a new game
            $res1 = "New game session: " . strval(rand());
            $theGame = new TheGameHistogram($nrDice, $playerArr);

            # Create a first player & play
            $firstPlayer = $theGame->getFirstPlayer();
            $res = $theGame->playGame($firstPlayer);

            # Save the game obj to the session
            $this->app->session->set("theDiceGame2", serialize($theGame));

            # Print the players score
            $thePlayersRes = $theGame->getPlayersScore();

            # Print the histogram of the current round
            $histogram = $theGame->getHistogram();

            # Create the histogram for the whole game
            $aHistogram = new Histogram();
            $aHistogram->injectData($theGame);
            $wholeGameHistogram = $aHistogram->getAsText();

            # Print the statistics
            $statistics = $theGame->getStatistics();
        }


        $restartForm = "<button class='gameBtn'> <a href='reset'> New game </a> </button>";

      // Setting the content for the view
        $data = [
          "class" => "TheDiceGame2",
          "gameHeader" => "<h1>The dice game2 </h1>",
          "histogram" => "<h3> Histogram of this round</h3>".$histogram."<br/>".
                         "<h3> Histogram of whole game</h3>".$wholeGameHistogram."<br/>".$statistics,
          "players" => "<h3> The players </h3>".$thePlayersRes,
          "content" => $res."</br>".$restartForm,
        ];

        // Adding the content to the view
        $this->app->page->add("anax/diceGame2/diceGame2", $data);


        // Returning the total
        return $this->app->page->render([
          "title" => $title,
        ]);
    }



    /**
    *
    * Reset the game
    *
    * @return object
    *
    */
    public function resetAction() : object
    {
           // Unset all of the session variables.
           #$this->app->session = [];

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
           $this->app->session->destroy();

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
          $this->app->page->add("anax/diceGame2/diceGame2", $data);


          // Returning the info
          return $this->app->page->render([
              "title" => $title,
          ]);
    }



    /**
    *
    * Play the game again
    *
    * @return object
    *
    */
    public function playAgainActionGet() : object
    {

      /**
       * Catch the user/computers choice
       * Play again or register points
       *
       * Get the game object from the session & register the necessary
       *
       */

        if ($this->app->session->has("theDiceGame2")) {
            # Get game session
            $theGame = unserialize($this->app->session->get("theDiceGame2"));

            # Get the form arguments
            # If more games are requested, register that in object
            # Save the object in the session
            $playAgain = $this->app->request->getGet('play');

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
                $this->app->session->set("theDiceGame2", serialize($theGame));
        } else {
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
          $this->app->page->add("anax/diceGame2/diceGame2", $data);


          // Returning the total
          return $this->app->page->render([
              "title" => $title,
          ]);
    }



    /**
    *
    * Next player
    *
    * @return object
    *
    */
    public function nextPlayerAction() : object
    {
        /**
         * Catch the user/computers choice
         * Play again or register points
         *
         * Get the game object from the session & register the necessary
         *
         */

          // Use the game object & change the player to next one
        if ($this->app->session->has("theDiceGame2")) {
            # Get game session
            $theGame = unserialize($this->app->session->get("theDiceGame2"));

            # Change player to next
            $theGame->nextPlayer();

            # Get current player
            $nextPlayer = $theGame->getCurrentPlayer();

            # Report which player is next
            $reply = $nextPlayer->getName();

            # Save the changes
            $this->app->session->set("theDiceGame2", serialize($theGame));
        }

            $reply .= "<a href='playGame' class='gameBtn'> Ok </a>";

            # Save the game session
            $this->app->session->set("theDiceGame2", serialize($theGame));


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
            $this->app->page->add("anax/diceGame2/diceGame2", $data);


            // Returning the total
            return $this->app->page->render([
                "title" => $title,
            ]);
    }
}
