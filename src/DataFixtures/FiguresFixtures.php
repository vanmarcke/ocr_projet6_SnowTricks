<?php

namespace App\DataFixtures;

use App\Entity\SnowFigure;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FiguresFixtures extends Fixture implements DependentFixtureInterface
{
    public const FIGURE_DEMO_REFERENCE = 'figure';

    public function load(ObjectManager $manager): void
    {
        //create Figures Demo
        $figuresData = [
            ['name' => 'Mute',
                'slug' => 'mute',
                'description' => 'Consiste à attraper le ski inverse de la main qui grabe devant la fixation, généralement on croise les skis en faisant ce grab (par exemple ta main droite attrape ton ski gauche devant la fixation sur la carre extérieure).',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Sad',
                'slug' => 'sad',
                'description' => 'Appelé également Melancholie ou Style Week. Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Indy',
                'slug' => 'indy',
                'description' => 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière. C\'est le grab basique et stable par excellence. C\'est le premier grab à essayer, ses variantes sont nombreuses.',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Stalefish',
                'slug' => 'stalefish',
                'description' => 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière. Ce grab très à la mode peut s\'effectuer de nombreuses façons toutes étant souvent esthétiques.',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Tail Grabs',
                'slug' => 'tail-grab',
                'description' => 'Consiste à attraper le ski derrière la fixation généralement en croisant les skis, avec la main qui est du côté du ski grabé. Un des grabs les plus courants également dont le maitre n?est autre que Candide Thovex Le true Tail-grab : Variante du Tail-Grab où tu attrapes à la spatule arrière (plus dur).',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Nose Grabs',
                'slug' => 'nose-grab',
                'description' => 'Pareil que le Brebis sauf que tu grabes le ski opposé à ta main toujours devant la fixation et la carre intérieure.(pareil que le Critical sauf que t\'attrapes plus vers la spatule). (cf Jon Olsson qui a lancé la mode de ce grab).',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Japan',
                'slug' => 'japan',
                'description' => 'La main attrape le ski opposé en passant derrière le corps (elle attrape le ski derrière la fixation). Souvent en repliant la jambe grabé.',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Seat Belt',
                'slug' => 'seat-belt',
                'description' => 'Saisie du carre frontside à l\'arrière avec la main avant',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Truck Driver',
                'slug' => 'truck-driver',
                'description' => 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Crail',
                'slug' => 'crail',
                'description' => 'La main arrière grab la carre front devant la fix avant. La jambe arrière doit etre tendue. C\'est un indy avec la jambe arrière tendue.',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Indy Nosebone',
                'slug' => 'indy-nosebone',
                'description' => 'C\'est un indy avec la jambe avant tendue. (méfiance : trop tendue et la police du style te guète.',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Rotation Backside',
                'slug' => 'rotation-backside',
                'description' => 'Pour un goofy, dans le sens des aiguilles d\'une montre. Elle s\'effectue en lançant son épaule avant vers l\'arrière (rotations en vogue : 180° 540° et 720°).',
                'publish' => '1',
                'category' => 'Rotations', ],

            ['name' => 'Rotation Frontside',
                'slug' => 'rotation-frontside',
                'description' => 'Pour un régular, dans le sens des aiguilles d\'une montre. Elle s\'effectue en lançant l\'épaule arrière vers l\'avant (rotations en vogue : 540° 720°).',
                'publish' => '1',
                'category' => 'Rotations', ],

            ['name' => 'Rodeoback',
                'slug' => 'rodeoback',
                'description' => 'Backflip + rotation, genre tu fait un rodéo 540 tu fais ton backflip et en même temps tu tournes et retombes en fakie. Tu lances de côté en arrière.',
                'publish' => '1',
                'category' => 'Rotations', ],

            ['name' => 'Mistyflip',
                'slug' => 'mistyflip',
                'description' => 'c\'est une rotation back mélangée avec un frontflip, effectuée dans un pipe, c\'est un mac-twist, l\'impulsion à lieu sur les pointes de pied.',
                'publish' => '1',
                'category' => 'Rotations', ],
        ];

        $figure = new SnowFigure();
        $date = new DateTime();

        foreach ($figuresData as $figureData) {
            $figure = new SnowFigure();
            $figure->setName($figureData['name'])
                ->setSlug($figureData['slug'])
                ->setDescription($figureData['description'])
                ->setPublish($figureData['publish'])
                ->setCreatedAt($date)
                ->setSnowUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE))
                ->setSnowCategory($this->getReference(CategoryFixtures::CATEGORY_DEMO_REFERENCE . '_' . $figureData['category']));
            $manager->persist($figure);
            $this->addReference(self::FIGURE_DEMO_REFERENCE . '_' . $figureData['name'], $figure);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
