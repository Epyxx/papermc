# Minecraft for Docker
#     Copyright (C) 2022 Epyx

#     This program is free software; you can redistribute it and/or modify
#     it under the terms of the GNU General Public License as published by
#     the Free Software Foundation; either version 2 of the License, or
#     (at your option) any later version.

#     This program is distributed in the hope that it will be useful,
#     but WITHOUT ANY WARRANTY; without even the implied warranty of
#     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#     GNU General Public License for more details.

#     You should have received a copy of the GNU General Public License along
#     with this program; if not, write to the Free Software Foundation, Inc.,
#     51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
ARG ALPINE_VER=latest
FROM alpine:${ALPINE_VER}
COPY ./start.sh /root/
RUN apk update && apk upgrade && \
    apk add --no-cache openjdk17-jre-headless screen curl jq bash apache2 apache2-utils php8 php8-mbstring php8-openssl php8-apache2 && \
    rm -rf /var/cache/apk/* && \
    rm -f /var/www/localhost/htdocs/index.html && \
	echo '0	6	*	*	*	/etc/init.d/minecraft backup' > /etc/crontabs/root && \
	adduser -h /opt/minecraft -s /bin/bash -D minecraft && \
    mkdir -p /opt/minecraft && \
	mkdir -p /opt/minecraft/backup && \
    chown minecraft.minecraft /var/www/localhost/htdocs/ && \
	wget https://papermc.io/api/v2/projects/paper/versions/1.18.1/builds/214/downloads/paper-mojmap-1.18.1-214.jar -q -O /opt/minecraft/paper.jar && \
	echo eula=true > /opt/minecraft/eula.txt && \
    chown minecraft.minecraft /opt/minecraft && \
    chown minecraft.minecraft /opt/minecraft/* && \
	chmod +x /root/start.sh

COPY ./httpd.conf /etc/apache2/
COPY --chown=minecraft.minecraft ./web/. /var/www/localhost/htdocs/
COPY ./minecraft /etc/init.d/
VOLUME /var/www/localhost/htdocs
VOLUME /opt/minecraft
EXPOSE 80
EXPOSE 25565
ENV SERVICE=paper
ENV VERSION=1.19.2
ENV WEB_USER=mcadmin
ENV WEB_PASS=UseAStrongPasswordHere
ENV BACKUP_WORLDS="world world_nether world_the_end"
ENV BACKUP_DAYS=3
ENV HISTORY=1024
ENV JAVA_ARGS="-Xmx2G -Xms1G -Xmn768m -XX:+AlwaysPreTouch -XX:+DisableExplicitGC -XX:+ParallelRefProcEnabled -XX:+PerfDisableSharedMem -XX:-UsePerfData -XX:MaxGCPauseMillis=200 -XX:ParallelGCThreads=6 -XX:ConcGCThreads=2 -XX:+UseG1GC -XX:+UseCompressedOops -XX:InitiatingHeapOccupancyPercent=50 -XX:G1HeapRegionSize=1 -XX:G1HeapWastePercent=5 -XX:G1MixedGCCountTarget=8 -Dfile.encoding=UTF8"
WORKDIR /opt/minecraft
ENTRYPOINT ["/root/start.sh"]
