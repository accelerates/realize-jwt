<?php
    require_once 'vendor/autoload.php';
    
    $coverage = new \SebastianBergmann\CodeCoverage\CodeCoverage;
    $coverage->start('tests');

// ...
    
    $coverage->stop();
    
    $writer = new \SebastianBergmann\CodeCoverage\Report\Clover;
    $writer->process($coverage, './test');
    
    $writer = new \SebastianBergmann\CodeCoverage\Report\Html\Facade;
    $writer->process($coverage, './test');