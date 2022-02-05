<?php

namespace App\DataFixtures;

use App\Entity\SnowCategory;
use App\Entity\SnowComment;
use App\Entity\SnowFigure;
use App\Entity\SnowImage;
use App\Entity\SnowUser;
use App\Entity\SnowVideo;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DemoFixtures extends Fixture
{
    protected $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager)
    {
        //create categories
        $category = [];
        $categoriesName = ['Grabs', 'Rotations', 'Flips', 'Rotations désaxées', 'Slides', 'One foot tricks', 'Old school'];
        foreach ($categoriesName as $categoryName) {
            $category = new SnowCategory();
            $category->setName($categoryName);
            $manager->persist($category);
        }
        $manager->flush();

        //create first user
        $userDemo = new SnowUser();
        $password = $this->userPasswordHasher->hashPassword($userDemo, '123456');
        $userDemo->setUsername('Fred')
        ->setEmail('vmkdev@vmkdev.com')
        ->setPassword($password)
        ->setRoles([])
        ->setIsVerified('1')
        ->setCreatedAt(new DateTime());
        $manager->persist($userDemo);

        //create Figures Demo
        $figuresData = [];
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
                'slug' => 'tailgrab',
                'description' => 'Consiste à attraper le ski derrière la fixation généralement en croisant les skis, avec la main qui est du côté du ski grabé. Un des grabs les plus courants également dont le maitre n?est autre que Candide Thovex Le true Tail-grab : Variante du Tail-Grab où tu attrapes à la spatule arrière (plus dur).',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Nose Grabs',
                'slug' => 'nosegrab',
                'description' => 'Pareil que le Brebis sauf que tu grabes le ski opposé à ta main toujours devant la fixation et la carre intérieure.(pareil que le Critical sauf que t\'attrapes plus vers la spatule). (cf Jon Olsson qui a lancé la mode de ce grab).',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Japan',
                'slug' => 'japan',
                'description' => 'La main attrape le ski opposé en passant derrière le corps (elle attrape le ski derrière la fixation). Souvent en repliant la jambe grabé.',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Seat Belt',
                'slug' => 'seatbelt',
                'description' => 'Saisie du carre frontside à l\'arrière avec la main avant',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Truck Driver',
                'slug' => 'truckdriver',
                'description' => 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Crail',
                'slug' => 'crail',
                'description' => 'La main arrière grab la carre front devant la fix avant. La jambe arrière doit etre tendue. C\'est un indy avec la jambe arrière tendue.',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Indy Nosebone',
                'slug' => 'indynosebone',
                'description' => 'C\'est un indy avec la jambe avant tendue. (méfiance : trop tendue et la police du style te guète.',
                'publish' => '1',
                'category' => 'Grabs', ],

            ['name' => 'Rotation Backside',
                'slug' => 'rotationbackside',
                'description' => 'Pour un goofy, dans le sens des aiguilles d\'une montre. Elle s\'effectue en lançant son épaule avant vers l\'arrière (rotations en vogue : 180° 540° et 720°).',
                'publish' => '1',
                'category' => 'Rotations', ],

            ['name' => 'Rotation Frontside',
                'slug' => 'rotationfrontside',
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

        /** @var SnowCategoryRepository */
        $categoryRepository = $manager->getRepository(SnowCategory::class);
        $date = new DateTime();

        foreach ($figuresData as $figureData) {
            $figure = new SnowFigure();
            $category = $categoryRepository->findOneByName($figureData['category']);
            $figure->setName($figureData['name'])
                ->setSlug($figureData['slug'])
                ->setDescription($figureData['description'])
                ->setPublish($figureData['publish'])
                ->setCreatedAt($date)
                ->setSnowUser($userDemo)
                ->setSnowCategory($category);
            $manager->persist($figure);
        }

        $manager->flush();

        //add video
        $videosData = [];
        $videosData = [
            ['name' => 'Mute', 'url' => 'https://www.youtube.com/embed/CA5bURVJ5zk'],
            ['name' => 'Sad', 'url' => 'https://www.youtube.com/embed/KEdFwJ4SWq4'],
            ['name' => 'Rodeoback', 'url' => 'https://www.youtube.com/embed/pI-iykKk_z4'],
            ['name' => 'Indy', 'url' => 'https://www.youtube.com/embed/G_MEz7oJzro'],
            ['name' => 'Stalefish', 'url' => 'https://www.youtube.com/embed/f9FjhCt_w2U'],
            ['name' => 'Seat Belt', 'url' => 'https://www.youtube.com/embed/zUs2vE0iz_4'],
            ['name' => 'Truck Driver', 'url' => 'https://www.youtube.com/embed/9yyWXtIXtW4'],
        ];

        foreach ($videosData as $videoData) {
            $video = new SnowVideo();
            /** @var SnowFigureRepository */
            $figureRepository = $manager->getRepository(SnowFigure::class);
            $figure = $figureRepository->findOneByName($videoData['name']);
            $video->setSnowFigure($figure)
                ->setUrl($videoData['url'])
                ->setCreatedAt(new DateTime());
            $manager->persist($video);
        }
        $manager->flush();

        //add comment
        $commentsData = [];
        $commentsData = [
            ['name' => 'Mute',
                'content' => 'Perso! Je me suis vautré à chaque fois que j\'ai essayé', ],

            ['name' => 'Mute',
                'content' => 'C\'est la figure de Tony Hawk!!', ],

            ['name' => 'Rodeoback',
                'content' => 'Enfin je vais pouvoir parler le Djeunz et le comprendre', ],

            ['name' => 'Rodeoback',
                'content' => 'Trop cool !', ],

            ['name' => 'Stalefish',
                'content' => 'Sympa ce trick !', ],

            ['name' => 'Truck Driver',
                'content' => 'Merci pour ce site. J\'ai enfin les informations intéressantes concernant le monde du snowboard', ],

            ['name' => 'Crail',
                'content' => 'Ouille ça donne mal à la tête tout ce vocabulaire.... Mais je le mets dans mes bookmarks si un jour je veux me mettre à vraiment apprendre le langage freestyle!!!', ],
        ];

        foreach ($commentsData as $commentData) {
            $comment = new SnowComment();
            /** @var SnowFigureRepository */
            $figureRepository = $manager->getRepository(SnowFigure::class);
            $figure = $figureRepository->findOneByName($commentData['name']);
            $comment->setSnowFigure($figure)
                ->setSnowUser($userDemo)
                ->setContent($commentData['content'])
                ->setCreatedAt(new DateTime());
            $manager->persist($comment);
        }
        $manager->flush();

        //add img
        $imgsData = [];
        $imgsData = [
            ['slug' => 'Mute',
                'src' => '/img/demo/mute.jpg', ],

            ['slug' => 'Mute',
                'src' => '/img/demo/mute2.jpg', ],

            ['slug' => 'Mute',
                'src' => '/img/demo/mute3.jpg', ],

            ['slug' => 'Sad',
                'src' => '/img/demo/sad.jpg', ],

            ['slug' => 'Sad',
                'src' => '/img/demo/sad2.jpg', ],

            ['slug' => 'Sad',
                'src' => '/img/demo/sad3.jpg', ],

            ['slug' => 'Indy',
                'src' => '/img/demo/indy.jpg', ],

            ['slug' => 'Indy',
                'src' => '/img/demo/indy2.jpg', ],

            ['slug' => 'Stalefish',
                'src' => '/img/demo/stalefish.avif', ],

            ['slug' => 'Tail Grabs',
                'src' => '/img/demo/tailgrab.webp', ],

            ['slug' => 'Nose Grabs',
                'src' => '/img/demo/nosegrab.jpg', ],

            ['slug' => 'Japan',
                'src' => '/img/demo/japan-air.jpg', ],

            ['slug' => 'Japan',
                'src' => '/img/demo/japan-air2.jpg', ],

            ['slug' => 'Seat Belt',
                'src' => '/img/demo/seatbelt.avif', ],

            ['slug' => 'Seat Belt',
                'src' => '/img/demo/seatbelt2.jpg', ],

            ['slug' => 'Truck Driver',
                'src' => '/img/demo/truck.jpg', ],

            ['slug' => 'Truck Driver',
                'src' => '/img/demo/truck2.jpg', ],

            ['slug' => 'Crail',
                'src' => '/img/demo/crail.jpg', ],

            ['slug' => 'Crail',
                'src' => '/img/demo/crail2.jpg', ],

            ['slug' => 'Indy Nosebone',
                'src' => '/img/demo/Indy_Nosebone.webp', ],

            ['slug' => 'Indy Nosebone',
                'src' => '/img/demo/Indy_Nosebone2.jpg', ],

            ['slug' => 'Rotation Backside',
                'src' => '/img/demo/backside.jpg', ],

            ['slug' => 'Rotation Backside',
                'src' => '/img/demo/backside2.jpg', ],

            ['slug' => 'Rotation Frontside',
                'src' => '/img/demo/rotationfront.jfif', ],

            ['slug' => 'Rodeoback',
                'src' => '/img/demo/Rodeoback.jpg', ],

            ['slug' => 'Rodeoback',
                'src' => '/img/demo/Rodeoback2.jpg', ],

            ['slug' => 'Mistyflip',
                'src' => '/img/demo/mistyflip.jpeg', ],
        ];

        foreach ($imgsData as $imgData) {
            $image = new SnowImage();
            /** @var SnowFigureRepository */
            $figureRepository = $manager->getRepository(SnowFigure::class);
            $figure = $figureRepository->findOneByName($imgData['slug']);
            $image->setSnowFigure($figure)
                ->setCreatedAt(new DateTime())
                ->setSrc($imgData['src']);
            $manager->persist($image);
        }
        $manager->flush();
    }
}
