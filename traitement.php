<?php

    // Utilités fonction session_start():  
    // 1:  démarrer une session pour l'utilisateur courant
    // 2:  récupérer sa session (si une déjà présente), possible car au démarrage d'une session le serveur enregistrera un cookie PHPSESSID dans le navigateur client 
    //                                                           -> cookie contient identifiant de la session et sera transmis au serveur avec chaque requête HTTP effectuée par le client                                   
    session_start();


    
    // Pour éviter utilisateur accède directement à URL page traitement
    // et ainsi provoquer des erreurs  sur  la  page  qui  lui  présenterait  des  informations  que  nous  ne  souhaitons  pas dévoiler
    //  -> limiter l'accès à traitement.php par  les  seules  requêtes  HTTP provenant de la soumission de notre formulaire

    if(isset($_POST['submit'])){    // vérification clef submit dans tableau post, submit correspond à attribut name du formulaire



        // vérification intégrité des valeurs transmises dans le tableau post

            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            // FILTER_SANITIZE_STRING : supprime présence caractères spéciaux / balise HTML ou encode  -> Pas d'injection de code HTML possible

            $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            // FILTER_VALIDATE_FLOAT :  validera  le  prix  seulement si c'est bien un  nombre  à virgule
            // ajout de FILTER_FLAG_ALLOW_FRACTION :  permet l'utilisation du caractère "," ou "." pour la décimale
            
            $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);
            // FILTER_VALIDATE_INT : quantité validée  que  si  celle-ci  est  un nombre entier différent de zéro (qui est considéré comme nul)



        // vérification pour voir si filtres ont bien fonctionné
        if ($name && $price && $qtt){   // on ne les compare à rien de précis car si filtre échoue renverra false ou null

            // stockage des données en session -> tableau session

                // tableau associatif product pour chaque produit
                $product = [
                    "name" => $name,
                    "price" => $price,
                    "qtt" => $qtt,
                    "total" => $price*$qtt
                ];


            // enregistrement nouveau produit créé en session
            $_SESSION['products'][] = $product;
                //      clef  (dans tableau session)
                //  []  ->  raccourci indiquant à cet emplacement nouvelle entrée au futur tableau products
        }

    }   // condition true seulement si requête post transmet une clef submit au serveur
        // sinon redirection grâce à la fonction header()



    // Fonction header () : envoie un nouvel entête HTTP (les entêtes d'une réponse) au client
    // ici type d'appel "Location" -> réponse envoyée au client avec status code 302 -> redirection
    header("Location:index.php");

