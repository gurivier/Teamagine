<?php

$langs=['fr', 'en'];

function generate_php_provider(string $fullname, string $provider_template): void {
    global $langs;
    $path = pathinfo($fullname, PATHINFO_DIRNAME);
    $basename = basename($fullname, '.dev.php');
    $filename_dev_php = $basename.'.dev.php';
    
    $dir_depth = substr_count($path, '/');
    $WD = '';
    while ($dir_depth-- > 0) {
        $WD .= '../';
    }

    $filename_php = $basename.'.php';
    $filename_html = $basename.'-\'.$lang.\'.html';
    $out_fullname = str_replace($filename_dev_php, $filename_php, $fullname);
    
    echo '...generating provider file: '.$out_fullname."\n";
    
    $f_out = fopen($out_fullname, 'w');

    if (!$f_out) {
        die('Erreur ouverture fichier: '.$out_fullname);
    }
    
    $lines = file($provider_template);
    foreach ($lines as $line) {
        $patterns = [ '{FILENAME_PHP}', '{FILENAME_HTML}', '{FILENAME_DEV_PHP}', '{WD}' ];
        $replacers = [ $filename_php, $filename_html, $filename_dev_php, $WD ];
        $out_line = str_replace($patterns, $replacers, $line);
        fputs($f_out, $out_line);
    }

    fclose($f_out);
    
    $cache_dir_fullname = $path.'/cache';
    
    if (!is_dir($cache_dir_fullname)) {
        echo '...creating directory: '.$cache_dir_fullname."\n";
        mkdir($cache_dir_fullname, 0775);
    }
}

function generate_html_page(string $fullname): void {
    global $langs;
    $basename = basename($fullname, '.html.php');
    $filename_html_php = $basename.'.html.php';

    foreach ($langs as $lang) {
        $l = ($lang == '') ? '' : '-'.$lang;
        $filename_html = $basename.$l.'.html';
        $out_fullname = str_replace($filename_html_php, $filename_html, $fullname);
        echo '...generating static file: '.$out_fullname."\n";
        system("php $fullname $lang > $out_fullname");
    }
}

function build(string $provider_template): void {
    $dev_fullnames = [];
    $htm_fullnames = [];
    
    $entries = ['.'];
    while (count($entries) > 0) {
        $entry = array_pop($entries);
        $names = scandir($entry);

        foreach ($names as $name) {
            if ($name[0] != '.') {
                if (is_dir($entry.'/'.$name)) {
                    $entries[] = $entry.'/'.$name;
                }
                else if (str_ends_with($name, '.dev.php')) {
                    $dev_fullnames[] = $entry.'/'.$name;
                }
                else if (str_ends_with($name, '.html.php')) {
                    $htm_fullnames[] = $entry.'/'.$name;
                }
            }
        }
    }

    foreach ($htm_fullnames as $fullname){
        generate_html_page($fullname);
    }
    
    foreach ($dev_fullnames as $fullname){
        generate_php_provider($fullname, $provider_template);
    }

    $builder_cache_dir_fullname='builder/cache';
    
    if (!is_dir($builder_cache_dir_fullname)) {
        echo '...creating directory: '.$builder_cache_dir_fullname."\n";
        mkdir($builder_cache_dir_fullname, 0775);
    }

    $config_runtime_dir_fullname='config/runtime';
    
    if (!is_dir($config_runtime_dir_fullname)) {
        echo '...creating directory: '.$config_runtime_dir_fullname."\n";
        mkdir($config_runtime_dir_fullname, 0775);
    }
}

function clean(): void {
    global $langs;

    $cache_dir_fullnames=[];
    $provider_fullnames=[];
    $html_fullnames=[];
    
    $entries = ['.'];
    while (count($entries) > 0) {
        $entry = array_pop($entries);
        $names = scandir($entry);
    
        foreach ($names as $name) {
            if ($name[0] != '.') {
                if (is_dir($entry.'/'.$name)) {
                    if ($name == 'cache') {
                        $cache_dir_fullnames[] = $entry.'/'.$name;
                    }
                    else {
                        $entries[] = $entry.'/'.$name;
                    }
                }
                else if (str_ends_with($name, '.dev.php')) {
                    $fullname_php = str_replace('.dev.php', '.php', $entry.'/'.$name);
                    $provider_fullnames[] = $fullname_php;
                }
                else if (str_ends_with($name, '.html.php')) {
                    $fullname_html = str_replace('.html.php', '.html', $entry.'/'.$name);
                    $html_fullnames[] = $fullname_html;
                }
            }
        }
    }

    foreach ($cache_dir_fullnames as $cache_dir_fullname) {
        $names = scandir($cache_dir_fullname);
        foreach ($names as $name) {
            if ($name[0] != '.') {
                $fullname = $cache_dir_fullname.'/'.$name;
                echo '...deleting file: '.$fullname."\n";
                unlink($fullname);
            }
        }
        rmdir($cache_dir_fullname);
        echo '...deleting directory: '.$cache_dir_fullname."\n";
    }
    
    foreach ($provider_fullnames as $fullname) {
        if (file_exists($fullname)) {
            echo '...deleting file: '.$fullname."\n";
            unlink($fullname);
        }
    }

    foreach ($html_fullnames as $fullname) {
        foreach ($langs as $lang){
            $fullname_lang = str_replace('.html', '-'.$lang.'.html', $fullname);
            if (file_exists($fullname_lang)) {
                echo '...deleting file: '.$fullname_lang."\n";
                unlink($fullname_lang);
            }
        }
    }
}

function clean_cache_files(): void {
    global $langs;

    $cache_dir_fullnames=[];
    
    $entries = ['.'];
    while (count($entries) > 0) {
        $entry = array_pop($entries);
        $names = scandir($entry);
    
        foreach ($names as $name) {
            if ($name[0] != '.') {
                if (is_dir($entry.'/'.$name)) {
                    if ($name == 'cache') {
                        $cache_dir_fullnames[] = $entry.'/'.$name;
                    }
                    else {
                        $entries[] = $entry.'/'.$name;
                    }
                }
            }
        }
    }

    foreach ($cache_dir_fullnames as $cache_dir_fullname) {
        $names = scandir($cache_dir_fullname);
        foreach ($names as $name) {
            if ($name[0] != '.') {
                $fullname = $cache_dir_fullname.'/'.$name;
                //echo '...deleting file: '.$fullname."\n";
                unlink($fullname);
            }
        }
    }    
}

?>
