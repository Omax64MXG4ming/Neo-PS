require("dotenv/config");

const {
    Client,
    GatewayIntentBits,
    Collection,
    REST,
    Routes,
    ActivityType,
    MessageFlags
} = require("discord.js");

const axios = require("axios");
const fs = require("fs");

const bot = require("./bot");
const M = require("./setup.json");

const {
    isOwner,
    isModerator
} = require("./utils/permissions");

// ========================================
// CLIENT
// ========================================

const client = new Client({

    intents: [
        GatewayIntentBits.Guilds
    ]

});

client.commands =
    new Collection();

// ========================================
// CONTROL
// ========================================

const CONTROL_URL =
    process.env.CONTROL_URL ||
    "https://neops.x10.mx/index/bot-cfgHandler.php";

const CONTROL_INTERVAL =
    30 * 1000;

const CONTROL_TIMEOUT =
    5000;

// Estado del bot
let botEnabled = true;

// Evita varios intervalos
let controlStarted = false;

let controlInterval = null;

// Evita múltiples login
let loginStarted = false;

// ========================================
// LOAD COMMANDS
// ========================================

function loadCommands() {

    const commandFiles =
        fs
            .readdirSync("./cmds")
            .filter(
                file =>
                    file.endsWith(".js")
            );

    for (const file of commandFiles) {

        try {

            const command =
                require(`./cmds/${file}`);

            if (
                command.data &&
                command.execute
            ) {

                client.commands.set(
                    command.data.name,
                    command
                );

                console.log(
                    `[CMD] Loaded ${command.data.name}`
                );

            }

        } catch (err) {

            console.error(
                `[CMD] Failed loading ${file}:`,
                err.message
            );

        }

    }

}

// ========================================
// REGISTER COMMANDS
// ========================================

async function registerCommands() {

    try {

        const rest =
            new REST()
                .setToken(
                    process.env.BOT_TOKEN
                );

        const commands =
            client.commands.map(
                command =>
                    command.data.toJSON()
            );

        await rest.put(

            Routes.applicationCommands(
                client.user.id
            ),

            {
                body:
                    commands
            }

        );

        console.log(
            `[CMD] Registered ${commands.length} slash commands globally.`
        );

    } catch (err) {

        console.error(
            "[CMD] Failed to register commands:",
            err
        );

    }

}

// ========================================
// READY
// ========================================

client.once(
    "ready",
    async () => {

        console.log(
            "Login as " +
            client.user.username
        );

        // =================================
        // PRESENCE
        // =================================

        client.user.setPresence({

            activities: [
                {
                    name:
                        M.actionbot ||
                        "Neo PS",

                    type:
                        ActivityType.Playing
                }
            ],

            status:
                M.statusbot ||
                "online"

        });

        // =================================
        // COMMANDS
        // =================================

        await registerCommands();

        // =================================
        // GDPS STATUS
        // =================================

        if (
            M.channel &&
            !isNaN(
                M.channel.gdpsstatus
            ) &&
            Number(
                M.channel.gdpsstatus
            ) !== 0
        ) {

            try {

                bot.gdpsstatus(
                    client,
                    M
                );

            } catch (err) {

                console.error(
                    "[GDPS STATUS] Error:",
                    err.message
                );

            }

        } else {

            console.log(
                "gdpsstatus: Not Enabled"
            );

        }

    }
);

// ========================================
// DISCORD ERROR
// ========================================

client.on(
    "error",
    err => {

        console.error(
            "Client error:",
            err.message
        );

    }
);

// ========================================
// SLASH COMMANDS
// ========================================

client.on(
    "interactionCreate",
    async interaction => {

        if (
            !interaction.isChatInputCommand()
        ) {

            return;

        }

        const command =
            client.commands.get(
                interaction.commandName
            );

        if (!command) {

            return;

        }

        // =================================
        // OWNER
        // =================================

        if (
            command.permission ===
                "owner" &&
            !isOwner(interaction)
        ) {

            return interaction.reply({

                content:
                    "❌ This command is restricted to the bot owner.",

                flags:
                    MessageFlags.Ephemeral

            });

        }

        // =================================
        // MODERATOR
        // =================================

        if (
            command.permission ===
                "moderator" &&
            !isModerator(interaction)
        ) {

            return interaction.reply({

                content:
                    "❌ This command is restricted to moderators and the bot owner.",

                flags:
                    MessageFlags.Ephemeral

            });

        }

        // =================================
        // EXECUTE
        // =================================

        try {

            await command.execute(
                interaction,
                client
            );

        } catch (err) {

            console.error(
                err
            );

            const msg = {

                content:
                    "An error occurred while running this command.",

                flags:
                    MessageFlags.Ephemeral

            };

            try {

                if (
                    interaction.replied ||
                    interaction.deferred
                ) {

                    await interaction.editReply(
                        msg
                    );

                } else {

                    await interaction.reply(
                        msg
                    );

                }

            } catch (replyErr) {

                console.error(
                    "Failed to send error reply:",
                    replyErr.message
                );

            }

        }

    }
);

// ========================================
// START LOGIN
// ========================================

async function startLogin() {

    if (
        loginStarted
    ) {

        return;

    }

    if (
        !botEnabled
    ) {

        console.log(
            "[BOT] Disabled by remote control."
        );

        return;

    }

    if (
        !process.env.BOT_TOKEN
    ) {

        console.error(
            "[BOT] BOT_TOKEN is missing."
        );

        return;

    }

    loginStarted =
        true;

    try {

        console.log(
            "[BOT] Starting Discord login..."
        );

        await client.login(
            process.env.BOT_TOKEN
        );

    } catch (err) {

        loginStarted =
            false;

        console.error(
            "[BOT] Login failed:",
            err.message
        );

    }

}

// ========================================
// REMOTE CONTROL
// ========================================

async function checkControl() {

    try {

        const response =
            await axios.get(
                CONTROL_URL,
                {
                    timeout:
                        CONTROL_TIMEOUT,

                    headers: {
                        "Cache-Control":
                            "no-cache",

                        "Pragma":
                            "no-cache"
                    }
                }
            );

        const data =
            response.data;

        if (
            !data ||
            typeof data !== "object"
        ) {

            throw new Error(
                "Invalid control response."
            );

        }

        const newState =
            Number(data.bot) === 1;

        // =================================
        // NO CHANGE
        // =================================

        if (
            newState === botEnabled
        ) {

            return;

        }

        botEnabled =
            newState;

        console.log(
            `[BOT] Remote control: ${
                botEnabled
                    ? "ENABLED"
                    : "DISABLED"
            }`
        );

        // =================================
        // ENABLE
        // =================================

        if (
            botEnabled
        ) {

            await startLogin();

        }

        // =================================
        // DISABLE
        // =================================
        //
        // No destruimos el cliente.
        // Solo dejamos de iniciar/reiniciar
        // el bot automáticamente.
        //

    } catch (err) {

        console.error(
            "[BOT] Failed checking remote control:",
            err.message
        );

    }

}

// ========================================
// CONTROL MONITOR
// ========================================

function startControlMonitor() {

    if (
        controlStarted
    ) {

        return;

    }

    controlStarted =
        true;

    console.log(
        "[BOT] Remote control started."
    );

    console.log(
        "[BOT] Control URL:",
        CONTROL_URL
    );

    checkControl();

    controlInterval =
        setInterval(
            () => {

                checkControl();

            },
            CONTROL_INTERVAL
        );

}

// ========================================
// START
// ========================================

function start() {

    loadCommands();

    startControlMonitor();

}

// ========================================
// GET CLIENT
// ========================================

function getClient() {

    return client;

}

// ========================================
// GET BOT STATUS
// ========================================

function isEnabled() {

    return botEnabled;

}

// ========================================
// EXPORT
// ========================================

module.exports = {

    start,
    getClient,
    isEnabled

};
