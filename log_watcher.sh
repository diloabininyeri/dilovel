#!/bin/sh
sudo apt install inotify-tools
while inotifywait -e modify src/logs/error.log; do
  if tail -n1 src/logs/error.log | grep apache; then
    php console error:detected
    kdialog --msgbox "error log file changed"
  fi
done