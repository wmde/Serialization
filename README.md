[![Build Status](https://secure.travis-ci.org/wikimedia/mediawiki-extensions-Serialization.png?branch=master)](http://travis-ci.org/wikimedia/mediawiki-extensions-Serialization)

# Serialization

Small library defining a Serializer and a Deserializer interface.

Also contains various Exceptions and a few basic (de)serialization utilities.

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `serialization/serialization` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
Serialization 1.0:

    {
        "require": {
            "serialization/serialization": "1.0.*"
        }
    }

### Manual

Get the Serialization code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the Serialization library by including its entry point:
Serialization.php.

## Release notes

### 1.0

* Initial release.

## Links

* [Serialization on Packagist](https://packagist.org/packages/serialization/serialization)
* [Serialization on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:Serialization)
* [Latest version of the readme file](https://github.com/wikimedia/mediawiki-extensions-Serialization/blob/master/README.md)
