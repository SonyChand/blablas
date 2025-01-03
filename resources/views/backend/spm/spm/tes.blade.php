<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klon Terminal</title>
    <style>
        body {
            background-color: black;
            color: green;
            font-family: monospace;
        }

        #terminal {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }

        #input {
            width: 100%;
            background: black;
            color: green;
            border: none;
            outline: none;
            padding: 10px;
            font-size: 1em;
        }

        .response {
            white-space: pre-wrap;
            margin-top: 10px;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div id="terminal">
        <div id="output"></div>
        <input type="text" id="input" spellcheck="false" autofocus placeholder="Ketik perintah Anda di sini..." />
    </div>
    <script type="text/javascript">
        document.body.addEventListener('contextmenu', function(e) {
            e.preventDefault(); // Mencegah menu konteks muncul
        });
        const input = document.getElementById('input');
        const output = document.getElementById('output');

        const commands = {
            'help': 'Perintah yang tersedia: help, clear, calculate <ekspresi>, ask <pertanyaan>',
            'clear': () => {
                output.innerHTML = '';
            },
            'calculate': (expression) => {
                const result = safeEval(expression);
                output.innerHTML += `<div>Hasil: ${result}</div>`;
            },
            'ask': async (question) => {
                const response = await getAIResponse(question);
                output.innerHTML += `<div class="response">Lord Daud: ${response}</div>`;
            }
        };

        function safeEval(expression) {
            try {
                return Function('"use strict";return (' + expression + ')')();
            } catch (error) {
                return 'Error: Ekspresi tidak valid';
            }
        }

        async function getAIResponse(question) {
            const apiKey = 'AIzaSyAuMuRiL3Kw2lHscJcJUryNSWMEVp-gpak'; // Ganti dengan kunci API Anda
            const url =
                `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`;

            const requestBody = {
                contents: [{
                    parts: [{
                        text: question
                    }]
                }]
            };

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestBody)
                });

                if (!response.ok) {
                    throw new Error('Respons jaringan tidak ok');
                }

                const data = await response.json();

                // Log respons untuk debugging
                console.log(data);

                // Periksa apakah data memiliki struktur yang diharapkan
                if (data.candidates && data.candidates.length > 0 &&
                    data.candidates[0].content &&
                    data.candidates[0].content.parts &&
                    data.candidates[0].content.parts.length > 0) {

                    return data.candidates[0].content.parts[0].text; // Ambil teks dari respons
                } else {
                    return 'Error: Struktur respons tidak terduga';
                }
            } catch (error) {
                return `Error: ${error.message}`;
            }
        }

        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const command = input.value;
                output.innerHTML += `<div>${command}</div>`;

                const [cmd, ...args] = command.split(' ');
                if (commands[cmd]) {
                    if (typeof commands[cmd] === 'function') {
                        commands[cmd](args.join(' ')); // Pass the arguments to the command
                    } else {
                        output.innerHTML += `<div>${commands[cmd]}</div>`;
                    }
                } else {
                    output.innerHTML +=
                        `<div class="error">Perintah tidak ditemukan: ${command}</div><br>Perintah yang tersedia: help, clear, calculate, ask`;
                }
                input.value = '';
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target !== input) {
                input.focus(); // Fokuskan kolom input jika area lain diklik
            }
        });
    </script>
</body>

</html>
