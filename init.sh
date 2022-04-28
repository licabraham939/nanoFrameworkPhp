#!/bin/bash
sudo /etc/init.d/apache2 stop
# service mysql status
# service mysql stop
sudo /opt/lampp/lampp start
php -S localhost:5000
