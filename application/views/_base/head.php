<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php foreach ($meta_data as $name => $content) : ?>
            <meta name='<?php echo $name; ?>' content='<?php echo $content; ?>'>
        <?php endforeach; ?>

        <?php
        foreach ($stylesheets as $media => $files) {
            foreach ($files as $file) {
                $url = starts_with($file, 'http') ? $file : base_url($file);
                echo "<link href='$url' rel='stylesheet' media='$media'>" . PHP_EOL;
            }
        }
        echo PHP_EOL;
        foreach ($varsJs['head'] as $var => $value) {
            echo "<script type='text/javascript'>" . PHP_EOL;
            echo "    var " . $var . "=" . $value . ";" . PHP_EOL;
            echo "</script>" . PHP_EOL;
        }
        echo PHP_EOL;
        foreach ($scripts['head'] as $file) {
            $url = starts_with($file, 'http') ? $file : base_url($file);
            echo "<script type='text/javascript' src='$url'></script>" . PHP_EOL;
        }
        echo PHP_EOL;
        foreach ($scriptssource['head'] as $script) {
            echo "<script type='text/javascript' >" . PHP_EOL;
            echo $script . PHP_EOL;
            echo "</script>" . PHP_EOL;
        }
        echo PHP_EOL;
        ?>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <title><?php echo $page_title; ?></title>

    </head>
    <body id="page-top" 
          <?php echo isset($body_class) ? 'class="' . $body_class . '"' : ''; ?>>
