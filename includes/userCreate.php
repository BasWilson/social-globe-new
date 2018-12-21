    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../mailer/Exception.php';
    require '../mailer/PHPMailer.php';
    require '../mailer/SMTP.php';

    $username = strtolower($_POST['username']);
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($username) && isset($password) && isset($email)) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 0;
            return;
        }
        writeToJson($username, $password, $email);

    } else {
        echo 0;
        return;
    }

    function writeToJson($username, $password, $email) {

        $file = "../data/users.json";
        $jsondata = file_get_contents($file);
        $data = json_decode($jsondata);

        foreach ($data->users as $key => $user) {
            if ($user->username == $username) {
                echo 0;
                return;
            }
        }
        $date = new DateTime();

        // Verstuur de welkoms email en sla de token op
        $emailToken = sendWelcomeEmail($email, $username);
        if (!$emailToken) {
            echo 0;
            return false;
        }

        // Maak het user object
        $user = (object) [
            'username' => strip_tags(strtolower($username)),
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'email' => $email,
            'sessionToken' => 0,
            'lastSignIn' => 0,
            'memberSince' => $date->getTimestamp(),
            'public' => true,
            'profilePic' => "default.png",
            'emailVerification' => $emailToken,
            'verified' => false,
            'darkMode' => false,
            'followers' => (array) [],
            'following' => (array) []
        ];

        // Push die in de array
        array_push($data->users, $user);

        $jsondata = json_encode($data, JSON_PRETTY_PRINT);

        // Schrijf de json data terug
        if(file_put_contents($file, $jsondata)) {
            // User is aangemaakt
            echo 1;
        } else {
            echo 0;
        }

    }


    function sendWelcomeEmail($email, $username) {

        $token = bin2hex(openssl_random_pseudo_bytes(64));

        $to = $email;
        $subject = "Welcome to The Social Globe";
        
        $message = '
        <html>
        <head>
        <title>Welcome to The Social Globe, '.$username.'</title>
        </head>
        <body>
        <p>Hi there '.$username.',</p>
        <p>We want to welcome you to The Social Globe, by clicking the link at the bottom of this email you will verify your account so you can use The Social Globe.</p>
        <a style="padding: 10px; text-align: center; border-radius: 9px; background-color: #FFD400; color: black; text-decoration: none; line-height: 30px;" href="https://www.82399.ict-lab.nl/social-globe/verify.php?token='.$token.'" >Verify email</a>
        <p>Have fun!</p>
        <p>The Social Globe team.</p>
        </body>
        </html>
        ';
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        $headers .= 'From: <noreply@baswilson.com>' . "\r\n";
        
        mail($to,$subject,$message,$headers);

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'baswilson.com;baswilson.com';            // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreply@baswilson.com';                 // SMTP username
        $mail->Password = 'yR{hXy-G{UB^';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('noreply@baswilson.com', 'The Social Globe');
        $mail->addAddress($email, $username);     // Add a recipient

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Welcome to The Social Globe';
        $mail->Body    = $message;

        $mail->send();
        
        return $token;

    } catch (Exception $e) {
        return false;
    }

    }

    ?>

