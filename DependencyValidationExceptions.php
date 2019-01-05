<?php
declare(strict_types=1);
/**
 * Class DependencyValidationException
 */
class DependencyValidationException extends Exception
{
}
/**
 * Class PackageNameValidationException
 */
class PackageNameValidationException extends DependencyValidationException
{
}
/**
 * Class MissedNameDependencyValidation
 */
class MissedNameDependencyValidation extends DependencyValidationException
{
}
/**
 * Class MissedKeyDependencyValidation
 */
class MissedKeyDependencyValidation extends DependencyValidationException
{
}
/**
 * Class SelfLinkedDependencyValidation
 */
class SelfLinkedDependencyValidation extends DependencyValidationException
{
}
/**
 * Class DeadlockDependencyValidation
 */
class DeadlockDependencyValidation extends DependencyValidationException
{
}