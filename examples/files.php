<?php
/**
 * Welcome to Learn Lesson
 * This is very Simple PHP Code of Caching
 * @author Khoa Bui (khoaofgod)  <khoaofgod@gmail.com> http://www.phpfastcache.com
 */

// Include composer autoloader
// require '../vendor/autoload.php';
require_once("../src/phpFastCache/phpFastCache.php");
/*
 * OR: require_once("../src/phpFastCache/phpFastCache.php");
 */
use phpFastCache\CacheManager;
$InstanceCache = CacheManager::Files();
// OR $InstanceCache = CacheManager::getInstance('files'); // files option is implicit but we specify it this time

/**
 * Try to get $products from Caching First
 * product_page is "identity keyword";
 */
$key = "product_page";
$CachedString = $InstanceCache->get($key);

if (is_null($CachedString)) {
    $CachedString = "Files Cache --> Cache Enabled --> Well done !";
    // Write products to Cache in 10 minutes with same keyword
    $InstanceCache->set($key, $CachedString, 600);

    echo "Files Cache --> Cached not enabled --> Reload page !";

} else {
    echo $CachedString;
}

echo '<br /><br /><a href="/">Back to index</a>&nbsp;--&nbsp;<a href="/' . basename(__FILE__) . '">Reload</a>';

