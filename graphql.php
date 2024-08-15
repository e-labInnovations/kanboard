<?php

require __DIR__ . '/app/common.php';

echo $container['graphql']->handleRequest();
