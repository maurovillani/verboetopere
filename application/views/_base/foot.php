<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo PHP_EOL;
foreach ($varsJs['foot'] as $var => $value) {
    echo "<script type='text/javascript'>" . PHP_EOL;
    echo "var " . $var . "='" . $value . "';" . PHP_EOL;
    echo "</script>" . PHP_EOL;
}
echo PHP_EOL;
foreach ($scripts['foot'] as $file) {
    $url = starts_with($file, 'http') ? $file : base_url($file);
    echo "<script type='text/javascript' src='$url'></script>" . PHP_EOL;
}
echo PHP_EOL;
foreach ($scriptssource['foot'] as $script) {
    echo "<script type='text/javascript' >" . PHP_EOL;
    echo $script . PHP_EOL;
    echo "</script>" . PHP_EOL;
}
echo PHP_EOL;
?>
</body>
</html>