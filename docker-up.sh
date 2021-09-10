#! /bin/bash

clear

# http://patorjk.com/software/taag/#p=display&f=Big&t=Docker-up
cat <<\EOF
  _____             _
 |  __ \           | |
 | |  | | ___   ___| | _____ _ __ ______ _   _ _ __
 | |  | |/ _ \ / __| |/ / _ \ '__|______| | | | '_ \
 | |__| | (_) | (__|   <  __/ |         | |_| | |_) |
 |_____/ \___/ \___|_|\_\___|_|          \__,_| .__/
                                              | |
                                              |_|

EOF


if [ ! -f "docker-compose.override.yml" ]; then
    printf '\e[1;33m%-6s\n\e[m' "Warning: the file \"docker-compose.override.yml\" didn't exist so Xdebug won't be enabled."
    printf '\e[1;33m%-6s\n\e[m' "If you want it, please run \"cp docker-compose.override.yml.dev docker-compose.override.yml\" to create the file first."
    printf '\e[1;33m%-6s\n\n\e[m' "(the file \"docker-compose.override.yml\" will enable the development environment)"

    printf '\e[1;32m%-6s\n\n\e[m' "Running Docker in a PROD environment"
    
else
    printf '\e[1;32m%-6s\n\n\e[m' "Running Docker in a DEV environment (with xDebug installed based on .env settings)"
fi

docker-compose up -d

# Read configuration from the .env file
APPLICATION_NAME="$(grep "APPLICATION_NAME" .env | cut -d "=" -f 2)"
APACHE_PORT="$(grep "APACHE_PORT" .env | cut -d "=" -f 2)"

printf '\e[1;32m\n%-6s\n\n\e[m' "Open a browser and navigate to http://127.0.0.1:$APACHE_PORT to let the script starts"
printf '\e[1;32m%-6s\n\n\e[m' "Run \"docker exec -it ${APPLICATION_NAME}_php /bin/bash\" in a CLI if you need to start an interactive shell"
