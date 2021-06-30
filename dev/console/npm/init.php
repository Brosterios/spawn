<?php declare(strict_types=1);

use bin\webu\IO;

IO::execInDir('composer run-script download-nodejs', ROOT);

include_once(__DIR__ . "/addNodeJsToPath.php");

//npx is installed as part of npm, which is installed as part of nodejs
//IO::execInDir('npm install -g npx', ROOT);

if (IO::exec('npm -v') !== 0) {
    IO::printLine("Please install npm!", IO::RED_TEXT);
    exit();
}

//IO::execInDir("npm install", ROOT . "/src/npm");
