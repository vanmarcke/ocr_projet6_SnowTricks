<?php

namespace App\DataFixtures;

use App\Entity\SnowComment;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMMENT_DEMO_REFERENCE = 'comment';

    public function load(ObjectManager $manager): void
    {
        //add comment
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

        foreach ($commentsData as $key => $commentData) {
            $comment = new SnowComment();
            $comment->setSnowFigure($this->getReference(FiguresFixtures::FIGURE_DEMO_REFERENCE . '_' . $commentData['name']))
                ->setSnowUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE))
                ->setContent($commentData['content'])
                ->setCreatedAt(new DateTime());
            $manager->persist($comment);
            $this->addReference(self::COMMENT_DEMO_REFERENCE . '_' . $key, $comment);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            VideoFixtures::class,
        ];
    }
}
