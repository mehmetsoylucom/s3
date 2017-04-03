<?php

namespace Wcms\PhonebookBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Wcms\PhonebookBundle\Entity\Book;

class BookToRedis
{
    protected $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Add
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Book) {
            return;
        }

        $this->redis->sAdd('students', $entity->getName());
    }

    /**
     * pre Edit
     *
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if (!$entity instanceof Book) {
            return;
        }

        if ($eventArgs->hasChangedField('name')) {
            $this->redis->sRem('students', $eventArgs->getOldValue('name'));
        }
    }

    /**
     * post Edit
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Book) {
            return;
        }

        $this->redis->sAdd('students', $entity->getName());
    }

    /**
     * Remove
     *
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Book) {
            return;
        }

        $this->redis->sRem('students', $entity->getName());
    }
}
