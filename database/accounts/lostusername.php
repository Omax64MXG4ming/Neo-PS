<?php
session_start();
/* CONFIGURACIÓN */
$host = "localhost";
$user = "noxfpmfd_neo";
$pass = "web_free";
$db   = "noxfpmfd_neo";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error DB: " . $conn->connect_error);
}

$message = "";

/* ENVIAR CÓDIGO */
if (isset($_POST['send_code'])) {

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT accountID, userName FROM accounts WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $account = $result->fetch_assoc();

        $code = rand(100000, 999999);

        $_SESSION['recover_code'] = $code;
        $_SESSION['recover_email'] = $email;
        $_SESSION['recover_account'] = $account;

        $subject = "Account Recovery";

        $body = "
Hello Neo GDPS User,

Your Verification Code is:

$code

If you did not request data recovery, disregard this message.
";

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "From: database@neops.x10.mx\r\n";

        if (mail($email, $subject, $body, $headers)) {
            $message = "Code Sent";
            $_SESSION['step'] = 2;
        } else {
            $message = "The email could not be sent";
        }

    } else {
        $message = "No account exists with the entered email address";
    }
}

/* VERIFICAR CÓDIGO */
if (isset($_POST['verify_code'])) {

    $code = trim($_POST['code']);

    if (
        isset($_SESSION['recover_code']) &&
        $code == $_SESSION['recover_code']
    ) {
        $_SESSION['verified'] = true;
    } else {
        $message = "Incorrect Code";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Account Recovery</title>
<style>
body {
    background-image: url("../bg.png");
    background-size: cover;      /* Ajusta la imagen a toda la pantalla */
    background-repeat: no-repeat; /* Evita que se repita */
    background-position: center;  /* Centra la imagen */
    margin: 0;
    font-family:Arial;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}


.card{
    width:420px;
    background:#1e293b;
    padding:25px;
    border-radius:15px;
    box-shadow:0 0 20px rgba(0,0,0,.4);
}

h1{
    text-align:center;
}

input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:8px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:8px;
    background:#3b82f6;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#2563eb;
}

.msg{
    margin-top:10px;
    text-align:center;
    color:#facc15;
}

.result{
    background:#0f172a;
    padding:15px;
    border-radius:10px;
    margin-top:15px;
}
</style>

</head>
<body>

<div class="card">

<h1>Username Recovery</h1>

<?php if (!isset($_SESSION['step'])): ?>

<form method="post">
    <input
        type="email"
        name="email"
        placeholder="your Email"
        required
    >
    <button name="send_code">
        Send Code
    </button>
</form>

<?php elseif (!isset($_SESSION['verified'])): ?>

<form method="post">
    <input
        type="text"
        name="code"
        placeholder="Received Code"
        required
    >
    <button name="verify_code">
        Verify
    </button>
</form>

<?php else: ?>

<div class="result">
    <h3>Account Found</h3>

    <p>
        <strong>User:</strong>
        <?= htmlspecialchars($_SESSION['recover_account']['userName']) ?>
    </p>

    <p>
        <strong>Account ID:</strong>
        <?= htmlspecialchars($_SESSION['recover_account']['accountID']) ?>
    </p>
</div>

<?php endif; ?>

<div class="msg">
    <?= htmlspecialchars($message) ?>
</div>

</div>

</body>
</html>