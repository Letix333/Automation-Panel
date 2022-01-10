#!/bin/bash

user=$1;
hostname=$2;
conf=$3;

echo $#;
echo $user;
echo $hostname;
echo $conf;
echo $4;
echo $5;


cd /var/www/html/scripts/ansible;
sudo ansible -m ping testing_1;
