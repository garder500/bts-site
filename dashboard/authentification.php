<html lang="fr">

<head>
    <?php
    $n = "Authentification"; // Titre
    $content = "Portail de connexion"; // Description
    $image = "/media/favicon.ico"; // Image
    $key = "manga, scan, shop, e-commerce, one piece, naruto"; // Mots clé
    $footer = true;
    $header = true;
    $default = true;
    require "../parts/head.php";
    $session = new SessionManager();
    if (isset($_SESSION['user'])) {
        header('Location: ../');
    }
    if (isset($_GET["action"]) == "logout") {
        $_SESSION["user"] = null;
        $_SESSION["articles"] = null;
        header('Location: ../');
    }

    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/styleAuthentification.css">
</head>

<body>
    <div id="pageMessages">

    </div>

    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form method="POST" enctype="multipart/form-data">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="hidden" name="signup" value="submit">
                <input type="text" name="username" placeholder="Username" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" id="passwd" placeholder="Password" required="">
                <input type="password" name="confirmPass" id="passwd2" placeholder="Password" required="">
                <button onclick="fillPassword()" type="button">Fill password</button>
                <input type="file" name="picture_user" placeholder="photo" required="">
                <?php
                if (isset($_POST['signup'])) {
                    $email = $_POST['email'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $confirmPass = $_POST['confirmPass'];
                    $auth->Register($email, $username, $password, $confirmPass, $_FILES['picture_user']);
                    if ($auth->getError()) {

                ?>
                        <script src="../public/js/Alert.js"></script>
                        <script>
                            createAlert('Oups!', 'Something went wrong', '<?= $auth->getError(); ?>', 'danger', false, true, 'pageMessages')
                        </script>
                    <?php
                    } else {
                        $_SESSION['user'] = $auth->getUser();
                        $commands = new Commande();
                        $commands->setUser($auth->getUser());
                        $commands->setPanier(true);
                        $commands->setId($auth->insert($commands));
                        $session->setCommande($commands);
                        
                    ?>
                        <script src="../public/js/Alert.js"></script>
                        <script>
                            createAlert('Success!', 'Wait 3 seconds before you get to the main page...', '<?= $auth->getSuccess(); ?>', 'success', false, true, 'pageMessages')
                        </script>
                <?php
                        echo '<script>setTimeout(function(){window.location.href="../index.php"},3000);</script>';
                    }
                }
                ?>
                <button>Sign up</button>
            </form>
        </div>

        <div class="login">
            <form method="POST">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="hidden" name="login" value="submit">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button>Login</button>
                <?php
                if (isset($_POST['login'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $auth->Login($email, $password);
                    if ($auth->getError()) {
                ?>
                        <script src="../public/js/Alert.js"></script>
                        <script>
                            createAlert('Oups!', 'Something went wrong', '<?= $auth->getError(); ?>', 'danger', false, true, 'pageMessages')
                        </script>
                    <?php
                    } else {
                        $_SESSION['user'] = $auth->getUser();
                        $commands = new Commande();
                        $commands->setUser($auth->getUser());
                        $commands->setPanier(true);
                        $checkIfPanierAlreadyExist = $auth->findOneBy("commande",["ID_USER" => $auth->getUser()->getId(), "PANIER" => 1]);
                        if ($checkIfPanierAlreadyExist) {
                            $commands->setId(intval($checkIfPanierAlreadyExist["ID_COMMANDE"]));
                        } else {
                            $commands->setId($auth->insert($commands));
                        }
                        $session->setCommande($commands);
                    ?>
                        <script src="../public/js/Alert.js"></script>
                        <script>
                            createAlert('Success!', 'Wait 3 seconds before you get to the main page...', '<?= $auth->getSuccess(); ?>', 'success', false, true, 'pageMessages')
                        </script>
                <?php
                        echo '<script>setTimeout(function(){window.location.href="../index.php"},3000);</script>';
                    }
                }

                ?>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        let pwd = document.getElementById("passwd"),
            pwd2 = document.getElementById("passwd2");

        // make a function to gen a password with a length of 8 characters,
        // with at least one number, one uppercase and one lowercase letter and one special character
        // and not three of the same character in a row
        function generatePassword() {
            let length = 8,
                retVal = "";

            function shuffleArray(array) {
                let currentIndex = array.length,
                    randomIndex;

                // While there remain elements to shuffle.
                while (currentIndex != 0) {

                    // Pick a remaining element.
                    randomIndex = Math.floor(Math.random() * currentIndex);
                    currentIndex--;

                    // And swap it with the current element.
                    [array[currentIndex], array[randomIndex]] = [
                        array[randomIndex], array[currentIndex]
                    ];
                }

                return array;
            }
            let lowerChar = "abcdefghijklmnopqrstuvwxyz",
                upperChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
                number = "0123456789",
                specialChar = "!@#$%^&*()_+",
                charSet = [lowerChar, upperChar, number, specialChar];

            for (let i = 0; i < length / 2; i++) {
                let shuffle = shuffleArray(charSet);
                for (let j = 0; j < shuffle.length; j++) {
                    retVal += shuffle[j].charAt(Math.floor(Math.random() * shuffle[j].length));
                }
                if (retVal.length > length) {
                    retVal = retVal.substring(0, length);
                }
            }
            console.log(retVal);
            return retVal;
        }

        // make a function to fill the password field with a generated password
        function fillPassword() {
            let passwordCurrent = generatePassword();
            pwd.value = passwordCurrent;
            pwd2.value = passwordCurrent;
        }
    </script>
</body>

</html>