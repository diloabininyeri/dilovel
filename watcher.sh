#!/bin/sh
sudo apt install inotify-tools
while inotifywait -e modify src/logs/error.log; do
    php console error:detected
    kdialog --msgbox "error log file changed"
done