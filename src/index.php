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
                $name = $_REQUEST['name'] ?? 'John Doe';

                // Add a breakpoint on the line below (press F9 in VSCode then press F5 to start a debugging session)
                echo "<p>Hello " . $name . "!, your name is <a href='?name=Denzel%20Washington'>" . $name . "</a> right?</p>";;
            ?>

            <h2>Step by step debugging</h2>

            <ol>
                <li>Copy the file <em>docker-compose.override.yml.dev</em> to <em>docker-compose.override.yml</em>,</li>
                <li>Run the <em>./docker-down.sh ; ./docker-up.sh</em> command in Linux to build the Docker services with php_debug enabled,</li>
                <li>Open Visual Studio Code,</li>
                <li>Open this project,</li>
                <li>Edit the <em>src/index.php</em> file,</li>
                <li>Add a breakpoint one the line with the <cite>echo "&lt;p&gt;Hello ..."</cite> (click somewhere on that line and press <kbd>F9</kbd>)</i>
                <li>Press <kbd>F5</kbd> to start the debugging session.</li>
                <li>Go back in the browser tab and press <kbd>F5</kbd> to refresh the page.</li>
            </ol>

            <p>If everything goes fine, VSCode will be in debug mode. The execution will be stopped on the line where you've put a breakpoint.</p>

            <p>In the <em>Debug Console</em>, type <em>$name='Christophe';</em> and press <kbd>Enter</kbd> to validate the change to that variable. Press <kbd>F5</kbd> to continue the execution of the script. The HTML page should reflect your change.</p>

            </div>
        </div>
    </section>
</body>
</html>
