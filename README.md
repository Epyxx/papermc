## Docker repository for epyx/papermc
#### This is a lightweight paper minecraft server with advanced web interface.

https://hub.docker.com/r/epyx/papermc

This image is based on Alpine Linux and uses the following additional packages:
> openjdk17-jre-headless screen curl jq bash apache2 apache2-utils php8 php8-mbstring php8-openssl php8-apache2

There are the following environment variables you can change:

```ts
SERVICE = paper // Defines the minecraft paper server type. There are the following options: paper,travertine,waterfall,velocity
VERSION = 1.19.2 // Sets the version of the server that will be downloaded/updated on every start
WEB_USER = mcadmin // The username for the login on the web interface (port 80)
WEB_PASS = UseAStrongPasswordHere // The password for the login on the web interface (port 80)
BACKUP_WORLDS = "world world_nether world_the_end" // The names of the world that will be backed up
BACKUP_DAYS = 3 // Number of days the backups will keep stored
HISTORY = 1024 // Log history for the screen command
JAVA_ARGS = "-Xmx2G -Xms1G -Xmn768m -XX:+AlwaysPreTouch -XX:+DisableExplicitGC -XX:+ParallelRefProcEnabled
-XX:+PerfDisableSharedMem -XX:-UsePerfData -XX:MaxGCPauseMillis=200 -XX:ParallelGCThreads=6 -XX:ConcGCThreads=2 -XX:+UseG1GC
-XX:+UseCompressedOops -XX:InitiatingHeapOccupancyPercent=50 -XX:G1HeapRegionSize=1 -XX:G1HeapWastePercent=5 -XX:G1MixedGCCountTarget=8
-Dfile.encoding=UTF8" // The Java Server arguments when running minecraft
```

There are also 2 volumes that you can mount/use

```
/opt/minecraft -- The main minecraft directory
/var/www/localhost/htdocs -- The webserver directory
```
