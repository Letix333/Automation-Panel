#!/bin/bash





if [[ -z `cat /var/www/html/scripts/ansible/inventories/host_vars/$1 2>/dev/null  | grep $2 ` ]]; then 
	echo "$2: true" >> /var/www/html/scripts/ansible/inventories/host_vars/$1;
fi
