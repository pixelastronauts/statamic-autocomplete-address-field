<?php

namespace Pixelastronauts\AddressField\Tests;

use Pixelastronauts\AddressField\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
