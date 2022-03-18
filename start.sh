#!/bin/sh
clear
touch current.build
API='https://papermc.io/api/v2'
CURRENT_BUILD="$(cat current.build)"
YELLOW='\033[1;33m'
NC='\033[0m'
LATEST_BUILD="$(curl -sX GET "$API"/projects/"$SERVICE"/versions/"$VERSION" -H 'accept: application/json' | jq '.builds | max')"
DOWNLOAD_URL="$API"/projects/"$SERVICE"/versions/"$VERSION"/builds/"$LATEST_BUILD"/downloads/"$SERVICE"-"$VERSION"-"$LATEST_BUILD".jar
echo -e "${YELLOW}> Welcome to Epyx' PaperMC Server with web interface ...${NC}"
echo -e "${YELLOW}> Setting up web server security ...${NC}"
touch /etc/apache2/.htpasswd
htpasswd -bc /etc/apache2/.htpasswd $WEB_USER $WEB_PASS

# Define Cronjob for Backups
echo "/etc/init.d/minecraft backup" > /etc/periodic/15min/backup
chmod +x /etc/periodic/15min/backup
mkdir -p /opt/minecraft/backup

# Check for new version and download newest jar file
cd /opt/minecraft
echo -e "${YELLOW}> Checking for new version ...${NC}"
if [[ "$CURRENT_BUILD" != "$LATEST_BUILD" ]]; then
	echo -e "${YELLOW}> Update required! Download newest version ...${NC}"
	rm paper.jar 2>/dev/null
	wget "$DOWNLOAD_URL" -q -O $SERVICE.jar
	echo $LATEST_BUILD > current.build
	echo -e "${YELLOW}> Update done!${NC}"
else
	echo -e "${YELLOW}> No Update required!${NC}"
fi

# Start jobs
echo -e "${YELLOW}> Starting cron daemon ...${NC}"
crond
/etc/init.d/minecraft start &
echo -e "${YELLOW}> You should now be able to config everything via web interface on port 80 ...${NC}"
httpd -D FOREGROUND
