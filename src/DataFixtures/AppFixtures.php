<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private string $filename = 'src/DataFixtures/dataset.sql';

    public function load(ObjectManager $manager)
    {
        $sql = file_get_contents($this->filename);
        $manager->getConnection()->exec($sql);

        $manager->flush();
    }
}
