<?php

return array(
    "driver" => "smtp",
    "host" => "mailtrap.io",
    "port" => 2525,
    "from" => array(
        "address" => "from@example.com",
        "name" => "Example"
    ),
    "username" => "5b910bb7dd876c",
    "password" => "aaa59a828f0422",
    "sendmail" => "/usr/sbin/sendmail -bs",
    "pretend" => false
);
