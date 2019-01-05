<?php
declare(strict_types=1);
/**
 * Class DependenciesChecker
 */
class DependenciesChecker
{
    /**
     * @param array $packages
     * @param array $usedDependencies
     * @throws SelfLinkedDependencyValidation
     * @throws DeadlockDependencyValidation
     * @return void
     */
    public function loopCheck(array $packages, array $usedDependencies): void
    {
        foreach ($packages as $key => $package) {
            $dependencies = $package['dependencies'];
            if (!empty($dependencies)) {
                if (in_array($package['name'], $dependencies)) {
                    throw new SelfLinkedDependencyValidation('Cycled dependency!');
                }
                $usedDependencies[] = $package['name'];
                foreach ($dependencies as $dependency) {
                    if (in_array($dependency, $usedDependencies)) {
                        throw new DeadlockDependencyValidation('Cycled dependency!');
                    }
                    $this->loopCheck($packages[$dependency], $usedDependencies);
                }
            }
        }
    }
    /**
     * @param array $packages
     * @throws PackageNameValidationException
     * @return void
     */
    public function identityCheck(array $packages): void
    {
        foreach ($packages as $key => $value) {
            if ($key !== $value['name']) {
                throw new PackageNameValidationException("$value[name] is not identically $key!");
            }
        }
    }
    /**
     * @param array $packages
     * @throws MissedKeyDependencyValidation
     */
    public function keysCheck(array $packages): void
    {
        foreach ($packages as $key => $value) {
            foreach ($value['dependencies'] as $keyDependencies => $valueDependencies) {
                if (!array_key_exists($valueDependencies, $packages)) {
                    throw new MissedKeyDependencyValidation("$valueDependencies is not in package array $key!");
                }
            }
        }
    }
    /**
     * @param array $packages
     * @throws MissedNameDependencyValidation
     * @return void
     */
    public function joinsCheck(array $packages): void
    {
        foreach ($packages as $key => $value) {
            if (array_key_exists("dependencies", $value) === false) {
                throw new MissedNameDependencyValidation("$key key have not any dependency!");
            }
        }
    }

}