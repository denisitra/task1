<?php


declare(strict_types=1);
require_once('DependenciesValidator.php');
$packages = [
    'A' => [
        'name' => 'A',
        'dependencies' => ['B', 'C'],
    ],
    'B' => [
        'name' => 'B',
        'dependencies' => [],
    ],
    'C' => [
        'name' => 'C',
        'dependencies' => ['B', 'D'],
    ],
    'D' => [
        'name' => 'D',
        'dependencies' => [],
    ]
];
try {
    $entity = new DependenciesValidator();
    $entity->getAllDependencies($packages,'A');
} catch (DependencyValidationException $e) {
    echo $e->getMessage();
}