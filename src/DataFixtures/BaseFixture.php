<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

abstract class BaseFixture extends Fixture implements FixtureGroupInterface
{
    protected string $folder;

    public function __construct()
    {
        $this->folder = __DIR__ . '/../../resources/dataFixtures';
    }
}
