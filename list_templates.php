<?php

$files = scandir("./0");

echo json_encode(array_slice($files,2));



?>