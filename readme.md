# Docker - xDebug

![Banner](./banner.svg)

* Make sure [Docker](https://www.docker.com/products/docker-desktop) is installed,
* Make sure you've installed the [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug) vscode addon of **Felix Becker**,
* Clone this repo in f.i. the `~/repos/` folder,
* In a DOS Prompt Session, go inside the folder of this project (`cd ~/repos/docker_xdebug`),
* Run `docker-compose up --build -d` and wait until the image has been created,
* Test the image: surf to `http://localhost/?name=John Doe` and you must see *Hello John Doe!*,
* Open Visual Studio Code and edit the `src/index.php` file,
* Put a breakpoint on a line (select the line and press <kbd>F9</kbd>)

  ![index with breakpoint](./images/index.png)

* Press <kbd>F5</kbd> to start a new debug instance,  
* If vscode ask for a configuration, select `Listen for XDebug - Docker app`. You'll see the debug toolbar and the color of the vscode statusbar will change to orange (default color)

  ![vscode deb ug toolbar](./images/debug_toolbar.png)

* Go back to your browser and refresh the page, vscode will immediately suspend the execution and will show this:

  ![index during the debugging](./images/index_debug.png)

At the left side of the editor, click on the *Debug* icon (or press <kbd>CTRL</kbd>+<kbd>SHIFT</kbd>+<kbd>D</kbd>) and you'll have now access to the variables.

Open the `Debug console` (press <kbd>CTRL</kbd>+<kbd>SHIFT</kbd>+<kbd>Y</kbd>) and type `$name='Christophe'` so you'll replace the value.

Press <kbd>F5</kbd> to continue the script and see your browser. The displayed name has been updated to yours.

## How it works

You need three files:

1. The `Dockerfile` contains a few statements to install the `xdebug` extension and to create a `xdebug.ini` file that will be used by Docker during the set-up of the container.
    Pay attention to the port: `xdebug.client_port=9001`. That port is important and should be exactly the same you'll use in the `.vscode/launch.json` file.
2. The `.vscode/launch.json` is used by vscode and need to specify which port to listen (the same used in `Dockerfile`) and how to map the file from within the Docker container to your file in vscode (see `pathMappings`)
3. The `docker-compose.yml` file has to initialize the `PHP_EXTENSION_XDEBUG: 1` variable in his `environment` section.
