#! /bin/bash

clear

# http://patorjk.com/software/taag/#p=display&f=Big&t=Docker-down
cat <<\EOF
  _____             _                       _                     
 |  __ \           | |                     | |                    
 | |  | | ___   ___| | _____ _ __ ______ __| | _____      ___ __  
 | |  | |/ _ \ / __| |/ / _ \ '__|______/ _` |/ _ \ \ /\ / / '_ \ 
 | |__| | (_) | (__|   <  __/ |        | (_| | (_) \ V  V /| | | |
 |_____/ \___/ \___|_|\_\___|_|         \__,_|\___/ \_/\_/ |_| |_|
                                                                  

EOF

printf '\e[1;32m%-6s\n\n\e[m' "Run docker-compose down..."
docker-compose down &>/dev/null

# Kill images based on the image name mentionned in the docker-compose.yml file
APPLICATION_NAME="$(grep "APPLICATION_NAME" .env | cut -d "=" -f 2)"
docker image rm "$(docker images | grep "${APPLICATION_NAME}_apache")" &>/dev/null
docker image rm "$(docker images | grep "${APPLICATION_NAME}_php")" &>/dev/null

## Get the current working directory but just the name (dirname); not the entire path
# Remove images like "docker_xdebug_apache" (where docker_xdebug is the current folder name)
CURDIR=${PWD##*/}
docker image rm "${CURDIR}_apache" &>/dev/null
docker image rm "${CURDIR}_php" &>/dev/null
