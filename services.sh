#!/bin/bash
#using  service.sh start|restart|stop 
#start all of service service.sh start 

services=(mysql redis-server elasticsearch kibana memcached php-fpm)
echo "$1"ing .....
for i in "${services[@]}";
do
  sleep 1
  if service --status-all | grep -Fq "$i"; then
    sudo service "$i" "$1"
    systemctl is-active --quiet "$i" && echo "$i" service is "$1"ed
  fi

done
