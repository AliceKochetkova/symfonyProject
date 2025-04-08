<?php

namespace App\EventListener;

use App\Entity\Blog;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postUpdate, method: 'preUpdate', entity: Blog::class)]
class BlogListener
{
    // the entity listener methods receive two arguments:
    // the entity instance and the lifecycle event
    public function preUpdate(Blog $blog, PostUpdateEventArgs $event): void
    {
        //dd($event);
    }
}