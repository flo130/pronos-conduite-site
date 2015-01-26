<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array(
    //le minifier ne va pas minifier les fichier contenant .min ou -min dans le nom
    //ceci permet de d'optimiser le temps de minification (tres long ici avec tous les fichiers, sur le raspberrypi...)
    
    'js' => array(
        /*** jquery ***/
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.min.js',
        /*** bootstrap twitter javascript ***/
        '/home/pi/pronos-conduite.com/assets/javascript/bootstrap.min.js',
        /*** load image only when user can see it in his browser ***/
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.lazyload.min.js',
        /*** manage graphics ***/
        '/home/pi/pronos-conduite.com/assets/javascript/highcharts.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/exporting.min.js',
        /*** manage file uploads ***/
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.ui.widget.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/load-image.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/canvas-to-blob.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.iframe-transport.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.fileupload.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.fileupload-process.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.fileupload-validate.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.fileupload-audio.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.fileupload-image.min.js',
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.fileupload-video.min.js',
        /*** provide html tabs to be sortable ***/
        '/home/pi/pronos-conduite.com/assets/javascript/jquery.tablesorter.min.js',
        /*** pronos-conduite javascripts ***/
        '/home/pi/pronos-conduite.com/assets/javascript/pronos-conduite.js',
        '/home/pi/pronos-conduite.com/assets/javascript/pronos-conduite-upload.js',
        '/home/pi/pronos-conduite.com/assets/javascript/pronos-conduite-graph.js',
        '/home/pi/pronos-conduite.com/assets/javascript/pronos-conduite-admin.js',
        '/home/pi/pronos-conduite.com/assets/javascript/pronos-conduite-tablesorter.js',
    ),
    
    
    'css' => array(
        '/home/pi/pronos-conduite.com/assets/css/bootstrap.min.css',
        '/home/pi/pronos-conduite.com/assets/css/font-awesome.min.css',
        '/home/pi/pronos-conduite.com/assets/css/bootswatch.min.css',
        '/home/pi/pronos-conduite.com/assets/css/jquery.fileupload.min.css',
        '/home/pi/pronos-conduite.com/assets/css/pronos-conduite.css',
        '/home/pi/pronos-conduite.com/assets/css/Lobster_1.3.otf',
    ),
);
