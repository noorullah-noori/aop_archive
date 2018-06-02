<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => public_path()."/../vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64",
        // 'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    // 'image' => array(
    //     'enabled' => true,
    //     'binary'  => public_path().'"/../vendor/wkhtmltox/bin/wkhtmltoimage"',
    //     'timeout' => false,
    //     'options' => array(),
    //     'env'     => array(),
    // ),


);
