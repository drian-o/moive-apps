const { WebSocketServer, WebSocket } = require('ws');
const pty = require('node-pty');

const PORT = Number(process.env.TERMINAL_PORT || 3001);

/*
|--------------------------------------------------------------------------
| Deteksi sistem otomatis
|--------------------------------------------------------------------------
|
| Windows  → PowerShell
| Linux    → Bash
|
| Karena file ini berada di root project, __dirname otomatis menjadi:
| Lokal      : C:\laragon\www\stream
| Production : folder project di server
|
*/

const isWindows = process.platform === 'win32';

const shell = isWindows
    ? 'powershell.exe'
    : process.env.SHELL || '/bin/bash';

const shellArgs = isWindows
    ? ['-NoLogo', '-NoProfile']
    : ['-l'];

const projectDirectory =
    process.env.TERMINAL_CWD || __dirname;

const websocketServer = new WebSocketServer({
    host: '127.0.0.1',
    port: PORT,
});

websocketServer.on('connection', socket => {
    console.log('Browser terhubung ke terminal.');

    const terminalProcess = pty.spawn(
        shell,
        shellArgs,
        {
            name: 'xterm-256color',
            cols: 120,
            rows: 30,
            cwd: projectDirectory,
            env: {
                ...process.env,
                TERM: 'xterm-256color',
            },
        }
    );

    terminalProcess.onData(data => {
        if (socket.readyState === WebSocket.OPEN) {
            socket.send(JSON.stringify({
                type: 'output',
                data,
            }));
        }
    });

    terminalProcess.onExit(({ exitCode }) => {
        console.log(`Terminal berhenti: ${exitCode}`);

        if (socket.readyState === WebSocket.OPEN) {
            socket.close(
                1000,
                `Terminal exited: ${exitCode}`
            );
        }
    });

    socket.on('message', rawData => {
        try {
            const message = JSON.parse(
                rawData.toString()
            );

            if (
                message.type === 'input' &&
                typeof message.data === 'string'
            ) {
                terminalProcess.write(message.data);
            }

            if (
                message.type === 'resize' &&
                Number.isInteger(message.cols) &&
                Number.isInteger(message.rows)
            ) {
                const cols = Math.min(
                    Math.max(message.cols, 20),
                    300
                );

                const rows = Math.min(
                    Math.max(message.rows, 5),
                    100
                );

                terminalProcess.resize(cols, rows);
            }
        } catch (error) {
            console.error(
                'Pesan terminal tidak valid:',
                error.message
            );
        }
    });

    socket.on('close', () => {
        console.log('Browser terputus.');

        try {
            terminalProcess.kill();
        } catch {
            // Proses sudah berhenti.
        }
    });
});

console.log(`Terminal aktif: ws://127.0.0.1:${PORT}`);
console.log(`Sistem: ${isWindows ? 'Windows' : 'Linux'}`);
console.log(`Shell: ${shell}`);
console.log(`Folder project: ${projectDirectory}`);