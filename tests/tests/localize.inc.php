<?php

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function (Lights\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('kamwanam@cse.msu.edu');
    $site->setRoot('/~kamwanam/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=kamwanam',
        'kamwanam',       // Database user
        'A56408889',     // Database password
        'testp2_');            // Table prefix

};