# Ra Framework client API

## Install

- composer require emerap/ra_client && composer install
- Create class extends from \Emerap\RaClient\Client.

## Basic usage

Basic implementation
```
<?php

namespace [YOUR_PACKAGE];

use Emerap\RaClient\Client

/**
 * Class CustomClient.
 *
 * @package [YOUR_PACKAGE]
 */
class CustomClient extends Client {
    
    /**
     * {@inheridoc}
     */
    public static function getSources() {
        // array of sources data.
    }

}
```
Usage
```
// Client tag (key in getSources).
$tag = 'ra_docs';

// CustomClient instance.
$client = new \YOUR_PACKAGE\CustomClient('ra_docs');
```