import { Terminal } from '@xterm/xterm';
import { FitAddon } from '@xterm/addon-fit';

import '@xterm/xterm/css/xterm.css';

document.addEventListener('DOMContentLoaded', () => {
    const terminalContainer =
        document.getElementById('terminal');

    const statusElement =
        document.getElementById('connection-status');

    if (!terminalContainer) {
        return;
    }

    const terminal = new Terminal({
        cursorBlink: true,
        fontSize: 14,
        fontFamily: 'Consolas, "Courier New", monospace',
        scrollback: 10000,
        theme: {
            background: '#000000',
            foreground: '#e2e8f0',
            cursor: '#60a5fa',
        },
    });

    const fitAddon = new FitAddon();

    terminal.loadAddon(fitAddon);
    terminal.open(terminalContainer);

    setTimeout(() => {
        fitAddon.fit();
    }, 100);

    const websocketUrl =
        import.meta.env.VITE_TERMINAL_WS_URL ||
        'ws://127.0.0.1:3001';

    const socket = new WebSocket(websocketUrl);

    socket.addEventListener('open', () => {
        if (statusElement) {
            statusElement.textContent = 'Connected';
            statusElement.className =
                'text-sm text-emerald-400';
        }

        fitAddon.fit();

        socket.send(JSON.stringify({
            type: 'resize',
            cols: terminal.cols,
            rows: terminal.rows,
        }));

        terminal.focus();
    });

    socket.addEventListener('message', (event) => {
        try {
            const message = JSON.parse(event.data);

            if (message.type === 'output') {
                terminal.write(message.data);
            }
        } catch {
            terminal.write(event.data);
        }
    });

    socket.addEventListener('close', () => {
        if (statusElement) {
            statusElement.textContent = 'Disconnected';
            statusElement.className =
                'text-sm text-red-400';
        }

        terminal.writeln(
            '\r\n\x1b[31mKoneksi terminal terputus.\x1b[0m'
        );
    });

    socket.addEventListener('error', () => {
        if (statusElement) {
            statusElement.textContent = 'Error';
            statusElement.className =
                'text-sm text-red-400';
        }

        terminal.writeln(
            '\r\n\x1b[31mTerminal server belum dijalankan.\x1b[0m'
        );
    });

    terminal.onData((data) => {
        if (socket.readyState !== WebSocket.OPEN) {
            return;
        }

        socket.send(JSON.stringify({
            type: 'input',
            data,
        }));
    });

    window.addEventListener('resize', () => {
        fitAddon.fit();

        if (socket.readyState === WebSocket.OPEN) {
            socket.send(JSON.stringify({
                type: 'resize',
                cols: terminal.cols,
                rows: terminal.rows,
            }));
        }
    });
});