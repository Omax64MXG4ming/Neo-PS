<?php

chdir(dirname(__FILE__));

require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/mainLib.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/XORCipher.php";
require_once "../lib/generateHash.php";
require_once "../lib/cron.php";

$gs = new mainLib();
$gh = new generateHash();

$current = time();

/*
 * ========================================
 * TYPE
 * ========================================
 *
 * 0 = Daily
 * 1 = Weekly
 * 2 = Event
 *
 * Algunos clientes/core antiguos envían
 * "weekly" en vez de "type".
 */

$type = 0;

if (isset($_POST["type"]) && $_POST["type"] !== "") {
    $type = intval($_POST["type"]);
} elseif (isset($_POST["weekly"]) && $_POST["weekly"] !== "") {
    $type = intval($_POST["weekly"]);
}

/*
 * ========================================
 * VALIDATE TYPE
 * ========================================
 */

if ($type < 0 || $type > 2) {
    exit("-1");
}

/*
 * ========================================
 * GET DAILY / WEEKLY / EVENT
 * ========================================
 */

$daily = false;
$dailyTable = "";
$isEvent = false;

switch ($type) {

    /*
     * DAILY / WEEKLY
     */
    case 0:
    case 1:

        $dailyTable = "dailyfeatures";

        /*
         * Buscamos el último Daily/Weekly
         * cuyo timestamp ya comenzó.
         */
        $query = $db->prepare("
            SELECT *
            FROM dailyfeatures
            WHERE timestamp <= :current
              AND type = :type
            ORDER BY timestamp DESC
            LIMIT 1
        ");

        $query->execute(array(
            ":current" => $current,
            ":type" => $type
        ));

        $daily = $query->fetch(PDO::FETCH_ASSOC);

        break;


    /*
     * EVENTS
     */
    case 2:

        $dailyTable = "events";
        $isEvent = true;

        /*
         * Event activo:
         *
         * timestamp = inicio
         * duration  = final
         */
        $query = $db->prepare("
            SELECT *
            FROM events
            WHERE timestamp <= :current
              AND duration >= :current
            ORDER BY duration ASC
            LIMIT 1
        ");

        $query->execute(array(
            ":current" => $current
        ));

        $daily = $query->fetch(PDO::FETCH_ASSOC);

        break;
}

/*
 * ========================================
 * NO DAILY FOUND
 * ========================================
 */

if (!$daily) {
    exit("-1");
}

/*
 * ========================================
 * REQUIRED DATA
 * ========================================
 */

if (!isset($daily["feaID"]) || !isset($daily["levelID"])) {
    exit("-1");
}

$feaID = intval($daily["feaID"]);
$levelID = intval($daily["levelID"]);

/*
 * ========================================
 * DAILY ID
 * ========================================
 *
 * Daily:
 *      feaID
 *
 * Weekly:
 *      feaID + 100000
 *
 * Event:
 *      feaID + 200000
 */

$dailyID = $feaID + ($type * 100000);

/*
 * ========================================
 * TIME LEFT
 * ========================================
 */

if ($isEvent) {

    /*
     * Events utilizan "duration"
     * como timestamp de finalización.
     */
    if (!isset($daily["duration"])) {
        exit("-1");
    }

    $timeleft = intval($daily["duration"]) - $current;

} else {

    /*
     * Daily/Weekly:
     *
     * timestamp representa el momento
     * en que fue creado/activado.
     *
     * Normalmente el cliente espera
     * el tiempo restante del Daily.
     *
     * Si tu tabla tiene duration, usamos
     * duration como finalización cuando
     * esté disponible.
     */

    if (isset($daily["duration"]) && intval($daily["duration"]) > $current) {
        $timeleft = intval($daily["duration"]) - $current;
    } else {
        /*
         * Compatibilidad con cores donde
         * timestamp + 86400/604800 representa
         * la duración.
         */
        if ($type == 1) {
            $timeleft = ($daily["timestamp"] + 604800) - $current;
        } else {
            $timeleft = ($daily["timestamp"] + 86400) - $current;
        }
    }
}

/*
 * Evitar tiempos negativos.
 */
if ($timeleft < 0) {
    $timeleft = 0;
}

/*
 * ========================================
 * WEBHOOK
 * ========================================
 */

$webhookSent = false;

if (isset($daily["webhookSent"])) {
    $webhookSent = intval($daily["webhookSent"]) == 1;
}

if (!$webhookSent) {

    /*
     * Enviar aviso de Daily/Weekly.
     */
    try {

        $gs->sendDailyWebhook(
            $levelID,
            $type
        );

    } catch (Exception $e) {

        /*
         * No hacemos que el Daily falle
         * solamente porque Discord/webhook
         * tenga un problema.
         */

    }

    /*
     * Marcar webhook como enviado.
     */
    if ($dailyTable == "dailyfeatures") {

        $sent = $db->prepare("
            UPDATE dailyfeatures
            SET webhookSent = 1
            WHERE feaID = :feaID
              AND type = :type
        ");

        $sent->execute(array(
            ":feaID" => $feaID,
            ":type" => $type
        ));

    } elseif ($dailyTable == "events") {

        $sent = $db->prepare("
            UPDATE events
            SET webhookSent = 1
            WHERE feaID = :feaID
        ");

        $sent->execute(array(
            ":feaID" => $feaID
        ));
    }

    /*
     * Creator Points
     *
     * El código original utilizaba
     * $accountID, pero aquí no existe.
     *
     * Para evitar Undefined variable,
     * solamente ejecutamos esto si existe.
     */
    if (
        isset($automaticCron) &&
        $automaticCron &&
        isset($accountID)
    ) {
        Cron::updateCreatorPoints(
            $accountID,
            false
        );
    }
}

/*
 * ========================================
 * EVENT RESPONSE
 * ========================================
 *
 * Events utilizan la respuesta especial
 * Sa1nt:XOR...
 */

$stringToAdd = "";

if ($isEvent) {

    /*
     * "chk" es necesario para generar
     * el token del evento.
     */
    if (
        !isset($_POST["chk"]) ||
        $_POST["chk"] === ""
    ) {
        exit("-1");
    }

    /*
     * Limpiar chk.
     */
    $chkInput = ExploitPatch::charclean(
        $_POST["chk"]
    );

    /*
     * El protocolo espera que chk
     * tenga los primeros 5 caracteres
     * antes del payload.
     */
    if (strlen($chkInput) <= 5) {
        exit("-1");
    }

    $chk = XORCipher::cipher(
        ExploitPatch::url_base64_decode(
            substr($chkInput, 5)
        ),
        59182
    );

    /*
     * Crear string del evento.
     */
    $eventString =
        "Sa1nt:" .
        $chk .
        ":" .
        ($feaID + 19) .
        ":3:" .
        (isset($daily["rewards"]) ? $daily["rewards"] : 0);

    $string = ExploitPatch::url_base64_encode(
        XORCipher::cipher(
            $eventString,
            59182
        )
    );

    /*
     * El protocolo de eventos
     * utiliza 10 segundos.
     */
    $timeleft = 10;

    /*
     * Generar hash.
     */
    $hash = $gh->genSolo4($string);

    $stringToAdd =
        "|Sa1nt" .
        $string .
        "|" .
        $hash;
}

/*
 * ========================================
 * RESPONSE
 * ========================================
 *
 * Daily:
 *
 *      dailyID|timeleft
 *
 * Event:
 *
 *      dailyID|10|Sa1nt...|hash
 */

echo $dailyID . "|" . $timeleft . $stringToAdd;

?>
