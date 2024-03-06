<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/css/style.css">
    <title>Labyrinthe</title>
</head>

<body>
    <header>
        <h1>Labyrinthe Mario</h1>
    </header>
    <main>
        <div>
            <?php
            session_start();

            // labyrenthe 1=mario   2=champignon   3=plante-carnivore   0 = brouillard

            
        // labyrinthe 1
            $maze = [
                [1, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 3, 0, 0],
                [0, 0, 3, 0, 0, 0, 3],
                [0, 3, 0, 0, 3, 0, 0],
                [3, 0, 3, 0, 0, 2, 0],
                [0, 0, 3, 0, 0, 0, 0]
            ];
            // afficher mon tableau au debut
            if (!isset($_SESSION['maze'])){
                $_SESSION['maze'] = $maze;
            }
            // labyrinthe 2
            $maze2 = [
                [1, 0, 0, 0, 0, 0, 0, 0],
                [0, 3, 0, 0, 3, 3, 0, 0],
                [0, 0, 3, 0, 3, 0, 0, 3],
                [0, 3, 0, 0, 3, 0, 0, 0],
                [3, 0, 3, 3, 0, 3, 0, 3],
                [0, 0, 3, 2, 0, 0, 0, 0],
                [0, 0, 3, 3, 0, 3, 0, 0],
            ];
            // variable des deux tableaux
            
            // nuage
            $arrCloud = [
                [4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4]
            ];
            $arrCloud2 = [
                [4, 4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4, 4],
                [4, 4, 4, 4, 4, 4, 4, 4],
            ];

            $randMaze = [$maze,$maze2];
            $randCloud = [$arrCloud,$arrCloud2];
            // fonction pour Afficher le labyrinthe
            function displayFogMaze($tab, $fogMaze)
            {
                foreach ($tab as $i => $line) {
                    foreach ($line as $j => $cell) {
                        if ($cell === 1) {
                            $fogMaze[$i][$j] = 1;
                            if (isset($fogMaze[$i - 1][$j]))
                                $fogMaze[$i - 1][$j] = $tab[$i - 1][$j];
                            if (isset($fogMaze[$i][$j - 1]))
                                $fogMaze[$i][$j - 1] = $tab[$i][$j - 1];
                            if (isset($fogMaze[$i][$j + 1]))
                                $fogMaze[$i][$j + 1] = $tab[$i][$j + 1];
                            if (isset($fogMaze[$i + 1][$j]))
                                $fogMaze[$i + 1][$j] = $tab[$i + 1][$j];
                        }

                    }
                }
                foreach ($fogMaze as $line) {
                    echo "<div class='line'>";
                    foreach ($line as $cell) {
                        switch ($cell) {
                            case 1:
                                // mario
                                echo "<div class='img' ><img id='player' src= './asset/images/mario.png' alt='mario'></div>";
                                break;
                            case 2:
                                // champignon
                                echo "<div class='img' ><img  src= './asset/images/champi.webp' alt='champignon'></div>";
                                break;
                            case 3:
                                // plante carnivore
                                echo "<div class='img' ><img  src= './asset/images/plante-carnivore.png' alt='plante'></div>";
                                break;
                            case 4:
                                // brouillard
                                echo "<div class='img' ><img  src= './asset/images/herbe.jpg' alt='brouillard'></div>";
                                break;
                            case 0:
                                // rien
                                echo "<div class='img' ><img  src= './asset/images/blanc.png' alt='brouillard'></div>";
                                break;
                        }

                    }
                    echo '</div>';
                }
                
            }


            // Fonction pour déplacer mario
// $direction = $_POST['direction'];
            function deplacerMario($direction, $arr, $fogMaze)
            {   //parcourir mon tableau
                foreach ($arr as $i => $line) {
                    foreach ($line as $j => $cell) {
                        //position de Mario
                        if ($arr[$i][$j] === 1) {
                            switch ($direction) {
                                case "haut": // boutton haut
                                    if (isset($arr[$i - 1][$j])) {
                                        // condition si Mario rencontre la plante carnivore
                                        if ($arr[$i - 1][$j] === 3) {
                                            $GLOBALS['alert'] = "Attention ! La plante carnivore va te manger !";
                                        } // condition parcourir le brouillard
                                        else if ($arr[$i - 1][$j] === 0) {
                                            $arr[$i - 1][$j] = 1;
                                            $arr[$i][$j] = 0;

                                        } else {
                                            $GLOBALS['alert'] = "Wahoo! tu a trouver le champignon !!!";

                                        }
                                    }
                                    $_SESSION['maze'] = $arr;
                                    break;
                                case "bas": // boutton bas
                                    if (isset($arr[$i + 1][$j])) {
                                        // condition si Mario rencontre la plante carnivore
                                        if ($arr[$i + 1][$j] === 3) {
                                            $GLOBALS['alert'] = "Attention ! La plante carnivore va te manger !";

                                        } // condition parcourir le brouillard
                                        else if ($arr[$i + 1][$j] === 0) {
                                            $arr[$i + 1][$j] = 1;
                                            $arr[$i][$j] = 0;
                                        } else {
                                            $GLOBALS['alert'] = "Wahoo! tu a trouver le champignon !!!";
                                        }

                                    }
                                    $_SESSION['maze'] = $arr;
                                    break;
                                case "gauche": // boutton gauche
                                    if (isset($arr[$i][$j - 1])) {
                                        // condition si Mario rencontre la plante carnivore
                                        if ($arr[$i][$j - 1] === 3) {
                                            $GLOBALS['alert'] = "Attention ! La plante carnivore va te manger !";

                                        } // condition parcourir le brouillard 
                                        else if ($arr[$i][$j - 1] === 0) {
                                            $arr[$i][$j - 1] = 1;
                                            $arr[$i][$j] = 0;
                                        } else {
                                            $GLOBALS['alert'] = "Wahoo! tu a trouver le champignon !!!";
                                        }
                                    }
                                    $_SESSION['maze'] = $arr;
                                    break;
                                case "droite": // boutton droite
                                    if (isset($arr[$i][$j + 1])) {
                                        // condition si Mario rencontre la plante carnivore
                                        if ($arr[$i][$j + 1] === 3) {
                                            $GLOBALS['alert'] = "Attention ! La plante carnivore va te manger !";

                                        } // condition parcourir le brouillard
                                        else if ($arr[$i][$j + 1] === 0) {
                                            $arr[$i][$j + 1] = 1;
                                            $arr[$i][$j] = 0;
                                        } else {
                                            $GLOBALS['alert'] = "Wahoo! tu a trouver le champignon !!!";
                                        }
                                    }
                                    $_SESSION['maze'] = $arr;
                                    break;
                            }
                            displayFogMaze($arr, $fogMaze);
                            
                            return;
                        }
                    }
                }
            }
            
            if (isset($_POST['direction'])) {
                deplacerMario($_POST['direction'], $_SESSION['maze'],$_SESSION['arrCloud'] ); 
            }
            else{
                if(isset ($_POST['refresh'])){
                session_destroy();
                header("refresh:0");
            }
            $random = rand(0,count($randMaze) - 1) ;
            $_SESSION['maze'] = $randMaze[$random];
            $_SESSION['arrCloud'] = $randCloud[$random];
            $_SESSION['mario'] = [0,0];
            displayFogMaze($_SESSION['maze'], $randCloud[$random]);
        }

            
            
            
            
            
            // if(isset ($_POST['refresh'])){
            //     session_destroy();
            //     header("refresh:0");
            // }
            // if (isset($_POST['direction'])) {
            //         deplacerMario($_POST['direction'], $_SESSION['maze'], $arrCloud); 
            //     }
            // else {
            //     $random = rand(0,count($randMaze) - 1) ;
            //     $_SESSION['maze'] = $randMaze[$random];
            //     displayFogMaze($maze, $arrCloud);
            // }
//lalala

            ?>
        </div>

        <form id="buttoncontainer" method="POST">
            
            <div class="cursor"><button id="haut" type="submit" name="direction" value="haut"></button></div>
            <div id="direction">
                <button id="gauche" type="submit" name="direction" value="gauche"></button>
                <button id="droite" type="submit" name="direction" value="droite"></button>
            </div>
            <div class="cursor"><button id="bas" type="submit" name="direction" value="bas"></button></div><br>
            <div id="play" >
                <button id="replay" type="submit" name="refresh" value="replay" >REPLAY</button>
            </div>
            <div id="text" >
                <?php
                echo isset($GLOBALS['alert']) ? $GLOBALS['alert'] : '';
                ?>
            </div>
            
        </form>
        

    </main>

</body>

</html>