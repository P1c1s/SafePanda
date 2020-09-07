#!/bin/bash

#Clean terminal
clear;

echo -e '\033[0;33m+\033[0;37m-------------------------\033[0;33mUpdater\033[0;37m------------------------\033[0;33m+\033[0;37m';
echo -e '|\033[0;34m     _____        __      ______                        \033[0;37m|';
echo -e '|\033[0;34m   /  ___|      / _|     | ___ \             | |        \033[0;37m|';
echo -e '|\033[0;34m   \ `--.  __ _| |_ ___  | |_/ /_ _ _ __   __| | __ _   \033[0;37m|';
echo -e '|\033[0;34m    `--. \/ _` |  _/ _ \ |  __/ _` |  _ \ / _` |/ _` |  \033[0;37m|';
echo -e '|\033[0;34m   /\__/ / (_| | ||  __/ | | | (_| | | | | (_| | (_| |  \033[0;37m|';
echo -e '|\033[0;34m   \____/ \__,_|_| \___| \_|  \__,_|_| |_|\__,_|\__,_|  \033[0;37m|';
echo -e '|                                                        |';
echo -e '\033[0;33m+\033[0;37m---------------------\033[0;33m'$(date +%a-%d-%m-%Y)'\033[0;37m---------------------\033[0;33m+';
echo -e '\033[1;37m';

echo "Hi, I am a the updater of Drive. You must execute me like root or sudoers."
read -p "Do you want exec me? YES [y] NO [n]: " decision


if [ "$decision" = "y" ]; then

   #Check the Package Manager

   DIR="/etc/apt"
   if [ -d "$DIR" ]; then

      #Updating
      apt-get update &&  apt-get upgrade -y

      #Installation of git
      apt-get install git -y

      #Installation of zip
      apt-get install zip -y

      #Installation of Apache2
      apt-get install apache2 -y && apt-get install php7.3 -y && apt-get install php7.3-zip -y && apt-get install php7.3-mysql -y && apt-get install libapache2-mod-php7.3 -y

      #Installation of mysql
       apt-get install mysql-server -y

   fi

   #Restart Daemons
   systemctl restart apache2
   systemctl restart mysql

   #Move SafePanda to web-root, Change PErmission, Remove installer and Show ip
   mv ../SafePanda* /var/www/html/SafePanda
   chown www-data /var/www/html/SafePanda/tmp -R && chgrp www-data /var/www/html/SafePanda/tmp -R
   chown www-data /var/www/html/SafePanda/account -R && chgrp www-data /var/www/html/SafePanda/account -R
   chown www-data /var/www/html/SafePanda/components -R && chgrp www-data /var/www/html/SafePanda/components -R
   rm /var/www/html/SafePanda/installer.sh
   echo '';

   #Configuration of mysql
   mysql < database.sql;

fi

#Stop for 5 seconds the script
sleep 5;

echo '  _____                 _   _ _       _   _                _____                      _      _           _';
echo ' |_   _|               | | | | |     | | (_)              / ____|                    | |    | |         | |';
echo '   | |  _ __  ___  __ _| |_| | | __ _| |_ _  ___  _ __   | |     ___  _ __ ___  _ __ | | ___| |_ ___  __| |';
echo '   | | |  _ \/ __|/ _` | __| | |/ _` | __| |/ _ \| _  \  | |    / _ \|  _ ` _ \|  _ \| |/ _ \ __/ _ \/ _` |';
echo '  _| |_| | | \__ \ (_| | |_| | | (_| | |_| | (_) | | | | | |___| (_) | | | | | | |_) | |  __/ ||  __/ (_| |';
echo ' |_____|_| |_|___/\__,_|\__|_|_|\__,_|\__|_|\___/|_| |_|  \_____\___/|_| |_| |_| .__/|_|\___|\__\___|\__,_|';
echo '                                                                               | |';
echo '                                                                               |_|';

#Stop for 3 seconds the script
sleep 3;

#Clean terminal
clear;

echo -e '\033[0;31m Open your browser and go to ' $(hostname -I)'/SafePanda';
