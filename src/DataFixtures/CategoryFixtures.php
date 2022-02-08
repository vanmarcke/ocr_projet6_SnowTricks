<?php

namespace App\DataFixtures;

use App\Entity\SnowCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_DEMO_REFERENCE = 'category';

    public function load(ObjectManager $manager): void
    {
        //create category
        $categoriesName = ['Grabs', 'Rotations', 'Flips', 'Rotations désaxées', 'Slides', 'One foot tricks', 'Old school'];
        foreach ($categoriesName as $categoryName) {
            $category = new SnowCategory();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference(self::CATEGORY_DEMO_REFERENCE . '_' . $categoryName, $category);
        }
        $manager->flush();
    }
}
