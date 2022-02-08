<?php

namespace App\DataFixtures;

use App\Entity\SnowVideo;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public const VIDEO_DEMO_REFERENCE = 'video';

    public function load(ObjectManager $manager): void
    {
        //add video
        $videosData = [
            ['name' => 'Mute', 'url' => 'https://www.youtube.com/embed/CA5bURVJ5zk'],
            ['name' => 'Sad', 'url' => 'https://www.youtube.com/embed/KEdFwJ4SWq4'],
            ['name' => 'Rodeoback', 'url' => 'https://www.youtube.com/embed/pI-iykKk_z4'],
            ['name' => 'Indy', 'url' => 'https://www.youtube.com/embed/G_MEz7oJzro'],
            ['name' => 'Stalefish', 'url' => 'https://www.youtube.com/embed/f9FjhCt_w2U'],
            ['name' => 'Seat Belt', 'url' => 'https://www.youtube.com/embed/zUs2vE0iz_4'],
            ['name' => 'Truck Driver', 'url' => 'https://www.youtube.com/embed/9yyWXtIXtW4'],
        ];

        foreach ($videosData as $key => $videoData) {
            $video = new SnowVideo();
            $video->setSnowFigure($this->getReference(FiguresFixtures::FIGURE_DEMO_REFERENCE . '_' . $videoData['name']))
                ->setUrl($videoData['url'])
                ->setCreatedAt(new DateTime());
            $manager->persist($video);
            $this->addReference(self::VIDEO_DEMO_REFERENCE . '_' . $key, $video);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FiguresFixtures::class,
        ];
    }
}
