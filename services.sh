#!/bin/bash

services=(mysql redis elasticsearch kibana memcached php-fpm)

for i in "${services[@]}"; do
  sleep 1
  if service --status-all | grep -Fq "$i"; then
    sudo service "$i" start
    systemctl is-active --quiet "$i" && echo "$i" service is started
  fi

done
