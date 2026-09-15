            ) ||
            fs.existsSync(
                outputFile
            )
        ) {

            removeFile(
                req.file.path
            );

            return res.json({

                success:
                    false,

                code:
                    2,

                error:
                    "Token already exists."

            });

        }

        // =================================
        // MOVE
        // =================================

        try {

            await fs.promises.rename(

                req.file.path,

                tempFile

            );

        } catch (err) {

            console.error(
                "[SFX] Failed moving uploaded file:",
                err.message
            );

            removeFile(
                req.file.path
            );

            return res.json({

                success:
                    false,

                code:
                    0,

                error:
                    "Failed saving uploaded file."

            });

        }

        // =================================
        // QUEUE
        // =================================

        songsQueue[
            song.token
        ] = {

            name:
                song.name,

            server:
                song.server,

            token:
                song.token,

            size:
                req.file.size

        };

        saveQueue();

        // =================================
        // START
        // =================================

        if (
            !isConverting &&
            sfxEnabled
        ) {

            checkQueue();

        }

        return res.json({

            success:
                true

        });

    }

);

// ========================================
// CHECK QUEUE
// ========================================

function checkQueue() {

    // ====================================
    // DISABLED
    // ====================================

    if (
        !sfxEnabled
    ) {

        console.log(
            "[SFX] Queue paused because converter is disabled."
        );

        return;

    }

    // ====================================
    // CONVERTING
    // ====================================

    if (
        isConverting
    ) {

        return;

    }

    // ====================================
    // EMPTY
    // ====================================

    const tokens =
        Object.keys(
            songsQueue
        );

    if (
        tokens.length === 0
    ) {

        isConverting =
            false;

        saveQueue();

        return;

    }

    const token =
        tokens[0];

    const song =
        songsQueue[token];

    // ====================================
    // REMOVE FROM QUEUE
    // ====================================

    delete songsQueue[token];

    saveQueue();

    // ====================================
    // CONVERT
    // ====================================

    convert(song);

}

// ========================================
// CONVERT
// ========================================

async function convert(
    song
) {

    isConverting =
        true;

    const oldPath =
        path.join(

            TEMP_DIR,

            song.token +
            "_temp.ogg"

        );

    const oggFilePath =
        path.join(

            TEMP_DIR,

            song.token +
            ".ogg"

        );

    try {

        console.log(
            "\n[SFX] Converting " +
            song.name +
            " from " +
            song.server +
            "..."
        );

        // =================================
        // FFMPEG
        // =================================

        await new Promise(
            (resolve, reject) => {

                ffmpeg()

                    .input(
                        oldPath
                    )

                    .outputOptions(
                        "-c:a libvorbis"
                    )

                    .output(
                        oggFilePath
                    )

                    .on(
                        "error",
                        reject
                    )

                    .on(
                        "end",
                        resolve
                    )

                    .run();

            }
        );

        // =================================
        // READ
        // =================================

        const convertedSong =
            await fs.promises.readFile(
                oggFilePath
            );

        console.log(
            "\n[SFX] Successfully converted " +
            song.name +
            " from " +
            song.server +
            " to .ogg"
        );

        // =================================
        // DELETE ORIGINAL
        // =================================

        removeFile(
            oldPath
        );

        // =================================
        // SEND GDPS
        // =================================

        const form =
            new FormData();

        form.append(
            "token",
            song.token
        );

        form.append(
            "file",
            convertedSong,
            {
                filename:
                    song.name
            }
        );

        try {

            const response =
                await axios.post(

                    song.server +
                    "update.php",

                    form,

                    {

                        headers:
                            form.getHeaders(),

                        maxContentLength:
                            Infinity,

                        maxBodyLength:
                            Infinity,

                        timeout:
                            60000

                    }

                );

            const result =
                response.data;

            if (
                !result ||
                !result.success
            ) {

                console.error(
                    "\n[SFX] Failed sending converted SFX!"
                );

                console.error(
                    result?.error ||
                    "Unknown server error"
                );

                console.log(
                    "[SFX] Server response:",
                    result
                );

            } else {

                console.log(
                    "\n[SFX] Successfully sent " +
                    song.name +
                    " to " +
                    song.server
                );

            }

        } catch (err) {

            console.error(
                "\n[SFX] Failed sending converted SFX:",
                err.message
            );

        } finally {

            removeFile(
                oggFilePath
            );

        }

    } catch (err) {

        console.error(
            "\n[SFX] Failed converting SFX:",
            err.message
        );

        console.log(
            "File name: " +
            song.name +
            ",\nServer: " +
            song.server +
            ",\nSize: " +
            (
                song.size /
                1024 /
                1024
            ).toFixed(2) +
            " MB"
        );

        removeFile(
            oldPath
        );

        removeFile(
            oggFilePath
        );

    } finally {

        isConverting =
            false;

        saveQueue();

        // =================================
        // NEXT
        // =================================

        setImmediate(
            () => {

                if (
                    sfxEnabled
                ) {

                    checkQueue();

                } else {

                    console.log(
                        "[SFX] Queue remains paused."
                    );

                }

            }
        );

    }

}

// ========================================
// QUERY VALIDATION
// ========================================

function checkQuery(
    req
) {

    const body =
        req.body;

    const file =
        req.file;

    if (!body) {

        return false;

    }

    if (
        typeof body.name ===
            "undefined" ||
        !body.name.length
    ) {

        return false;

    }

    if (
        typeof body.server ===
            "undefined" ||
        !body.server.length
    ) {

        return false;

    }

    if (
        typeof body.token ===
            "undefined" ||
        !body.token.length
    ) {

        return false;

    }

    if (
        !file
    ) {

        return false;

    }

    if (
        file.mimetype !==
            "audio/mpeg" &&
        file.mimetype !==
            "audio/mp3"
    ) {

        return false;

    }

    let serverHost;

    try {

        const parsed =
            new URL(
                body.server
            );

        serverHost =
            parsed.hostname;

    } catch (err) {

        return false;

    }

    // ====================================
    // DOMAIN LIST
    // ====================================

    if (
        Array.isArray(
            config.domainlist
        ) &&
        config.domainlist.length > 0
    ) {

        const isListed =
            config.domainlist.includes(
                serverHost
            );

        if (
            config.mode === true &&
            !isListed
        ) {

            return false;

        }

        if (
            config.mode === false &&
            isListed
        ) {

            return false;

        }

    }

    return true;

}

// ========================================
// REMOVE FILE
// ========================================

function removeFile(
    filePath
) {

    try {

        if (
            filePath &&
            fs.existsSync(
                filePath
            )
        ) {

            fs.unlinkSync(
                filePath
            );

        }

    } catch (err) {

        console.error(
            "[SFX] Failed deleting file:",
            filePath
        );

        console.error(
            err.message
        );

    }

}

// ========================================
// METHOD OVERRIDE
// ========================================

router.use(
    methodOverride()
);

// ========================================
// INITIALIZE
// ========================================

loadQueue();

startSfxControl();

// ========================================
// EXPORT
// ========================================

module.exports =
    router;
