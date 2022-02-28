<?php

namespace App\DataFixtures;

use App\Entity\SnowImage;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public const IMAGE_DEMO_REFERENCE = 'image';

    public function load(ObjectManager $manager): void
    {
        //add img
        $imgsData = [
            ['name' => 'Mute',
                'src' => '/img/demo/mute.jpg', ],

            ['name' => 'Mute',
                'src' => '/img/demo/mute2.jpg', ],

            ['name' => 'Mute',
                'src' => '/img/demo/mute3.webp', ],

            ['name' => 'Sad',
                'src' => '/img/demo/sad.jpg', ],

            ['name' => 'Sad',
                'src' => '/img/demo/sad2.jpg', ],

            ['name' => 'Sad',
                'src' => '/img/demo/sad3.jpg', ],

            ['name' => 'Indy',
                'src' => '/img/demo/indy.jpg', ],

            ['name' => 'Indy',
                'src' => '/img/demo/indy2.jpg', ],

            ['name' => 'Stalefish',
                'src' => '/img/demo/stalefish.avif', ],

            ['name' => 'Tail Grabs',
                'src' => '/img/demo/tailgrab.webp', ],

            ['name' => 'Nose Grabs',
                'src' => '/img/demo/nosegrab.jpg', ],

            ['name' => 'Japan',
                'src' => '/img/demo/japan-air.jpg', ],

            ['name' => 'Japan',
                'src' => '/img/demo/japan-air2.jpg', ],

            ['name' => 'Seat Belt',
                'src' => '/img/demo/seatbelt.avif', ],

            ['name' => 'Seat Belt',
                'src' => '/img/demo/seatbelt2.jpg', ],

            ['name' => 'Truck Driver',
                'src' => '/img/demo/truck.jpg', ],

            ['name' => 'Truck Driver',
                'src' => '/img/demo/truck2.jpg', ],

            ['name' => 'Crail',
                'src' => '/img/demo/crail.jpg', ],

            ['name' => 'Crail',
                'src' => '/img/demo/crail2.jpg', ],

            ['name' => 'Indy Nosebone',
                'src' => '/img/demo/Indy_Nosebone.webp', ],

            ['name' => 'Indy Nosebone',
                'src' => '/img/demo/Indy_Nosebone2.jpg', ],

            ['name' => 'Rotation Backside',
                'src' => '/img/demo/backside.jpg', ],

            ['name' => 'Rotation Backside',
                'src' => '/img/demo/backside2.jpg', ],

            ['name' => 'Rotation Frontside',
                'src' => '/img/demo/rotationfront.png', ],

            ['name' => 'Rodeoback',
                'src' => '/img/demo/Rodeoback.jpg', ],

            ['name' => 'Rodeoback',
                'src' => '/img/demo/Rodeoback2.jpg', ],

            ['name' => 'Mistyflip',
                'src' => '/img/demo/mistyflip.jpeg', ],
        ];

        foreach ($imgsData as $key => $imgData) {
            $image = new SnowImage();
            $image->setSnowFigure($this->getReference(FiguresFixtures::FIGURE_DEMO_REFERENCE . '_' . $imgData['name']))
                ->setCreatedAt(new DateTime())
                ->setSrc($imgData['src']);
            $manager->persist($image);
            $this->addReference(self::IMAGE_DEMO_REFERENCE . '_' . $key, $image);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CommentFixtures::class,
        ];
    }
}
