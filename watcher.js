const fs = require('fs');
const {exec} = require("child_process");
require('log-timestamp');

const logFile = './src/logs/error.log';
const command='php console error:detected';

console.log(`Watching for file changes on ${logFile}`);

fs.watchFile(logFile, () => {

    console.log(`${logFile} file Changed`);

    exec(command, (error, stdout, stderr) => {
        if (error) {
            console.log(`error: ${error.message}`);
            return;
        }
        if (stderr) {
            console.log(`stderr: ${stderr}`);
            return;
        }
        console.log(`stdout: ${stdout}`);
    });


});





