<?php
declare(strict_types=1);
require_once('DependencyValidationExceptions.php');
/**
 * Class DependenciesValidator
 */
class DependenciesValidator extends DependenciesChecker
{
    /**
     * @param array $packages
     * @param string $packageName
     * @return array
     * @throws DeadlockDependencyValidation
     * @throws SelfLinkedDependencyValidation
     * @throws MissedNameDependencyValidation
     * @throws MissedKeyDependencyValidation
     * @throws PackageNameValidationException
     */
    public function getAllDependencies(array $packages, string $packageName): array
    {
        $this->validateDefinitions($packages);
        $ArrayPackages = $this->getChilds($packages, $packageName);
        return $this->getResult($ArrayPackages);
    }
    /**
     * @param array $packages
     * @throws DeadlockDependencyValidation
     * @throws SelfLinkedDependencyValidation
     * @throws MissedNameDependencyValidation
     * @throws MissedKeyDependencyValidation
     * @throws PackageNameValidationException
     * @return void
     */
    public function validateDefinitions(array $packages): void
    {
        $this->identityCheck($packages);
        $this->joinsCheck($packages);
        $this->keysCheck($packages);
        $this->loopCheck($packages, []);
    }
    /**
     * @param array $packages
     * @param string $packageName
     * @return array
     */
    private function getChilds(array $packages, string $packageName): array
    {
        $result = [$packageName];
        foreach ($packages[$packageName]['dependencies'] as $key => $dependency) {
            if (count($dependency) !== 0) {
                $result[] = $this->getChilds($packages, $dependency);
            }
        }
        return $result;
    }
    /**
     * @param array $startArray
     * @return array
     */
    private function getResult(array $startArray): array
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($startArray));
        $crossArray = iterator_to_array($iterator, false);
        $result = array_reverse($crossArray);
        return array_unique($result);
    }
}