#!/bin/bash

apt install nginx nginx-full -y
cp /root/config/nginx/nginx.conf /etc/nginx/nginx.conf
cp /root/config/nginx/default.conf /etc/nginx/sites-available/default

echo "[DONE] nginx-installation.sh"
exit 0