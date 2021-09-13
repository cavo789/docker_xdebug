<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker - Set up your vscode environment with xDebug</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Docker - Set up your vscode environment with xDebug</h1>
            <div class="content">
                <?php
                    date_default_timezone_set('Europe/Brussels');
                    printf('<h2>%s</h2>', date('l, F jS Y G:i:s'));
                    printf('<h2>%s</h2>', 'PHP v' . phpversion());

                    if (!extension_loaded('xdebug')) {
                        printf(
                            '<div style="padding:10px;" class="has-background-danger-dark has-text-white"><p>%s</p>' .
                            '<ol><li>%s</li><li>%s</li><li>%s</li><li>%s</li></ol></div>',
                            'XDebug IS NOT INSTALLED. Please make sure:',
                            'the XDEBUG_INSTALL variable in your .env file is set to true,',
                            'you\'ve copy the file docker-compose.override.yml.dev and create docker-compose.override.yml,',
                            'restart Docker (run "./docker-down.sh ; ./docker-up.sh" in a console)',
                            'refresh this page'
                        );
                        die();
                    } else {
                        printf(
                            '<div style="padding:10px;" class="has-background-primary-dark has-text-white"><p>%s</p><p>%s</p></div><br/>',
                            'Congratulations, Xdebug v' . phpversion('xdebug') . ' IS INSTALLED AND ENABLED.',
                            'You can now go to your editor, add a breakpoint, press <kbd>F5</kbd> and refresh this page.'
                        );
                    }

        // Add a breakpoint on the line below (press F9 in VSCode then press F5 to start a debugging session)
        $name = $_REQUEST['name'] ?? 'John Doe';

        echo '<p>Hello ' . $name . "!, your name is <a href='?name=Denzel%20Washington'>" . $name . '</a> right?</p>';
                ?>

                <h2>Step by step debugging</h2>

                <ol>
                    <li>Make sure Xdebug is installed and enabled,</li>
                    <!-- <li>Open Visual Studio Code and this project (run <code>code .</code> in a console),</li> -->
                    <li>Edit the <code>src/index.php</code> file,</li>
                    <li>Navigate and add a breakpoint one the line with the <code>echo "&lt;p&gt;Hello ..."</code> (click somewhere on that line and press <kbd>F9</kbd>)</i>
                    <li>Still inside VSCode, press <kbd>F5</kbd> to start the debugging session,</li>
                    <li>Go back in the browser tab and press <kbd>F5</kbd> to refresh the page.</li>
                </ol>

                <p>If everything goes fine, VSCode will be in debug mode. The execution will be stopped on the line where you've put a breakpoint.</p>

                <p>In the <em>Debug Console</em>, type <em>$name='Christophe';</em> and press <kbd>Enter</kbd> to validate the change to that variable. Press <kbd>F5</kbd> to continue the execution of the script. The HTML page should reflect your change.</p>

            </div>
        </div>
    </section>
</body>
</html>
