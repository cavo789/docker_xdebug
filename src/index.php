<?php
// Add a breakpoint on the line f.i. (press F9 in VSCode)
$name = $_REQUEST['name'] ?? 'John Doe';

echo "<h1>Hello " . $name . "!</h1>";

echo "<p>Now, edit the index.php file in VSCode, add a breakpoint " .
    "and press F5 to start the debugging. Go back in the browser tab " .
    "and press CTRL-F5. If everything goes fine, VSCode will be in debug mode.</p>";
