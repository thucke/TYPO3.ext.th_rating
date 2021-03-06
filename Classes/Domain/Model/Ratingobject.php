<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Domain\Model;

use Thucke\ThRating\Domain\Repository\RatingRepository;
use Thucke\ThRating\Domain\Repository\StepconfRepository;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Aggregate object for rating of content objects
 *
 * @version  $Id:$
 * @copyright  Copyright belongs to the respective authors
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @entity
 */
class Ratingobject extends AbstractEntity
{
    /**
     * Table name of the cObj
     * Defaults to Typo3 tablename of pages
     *
     * @Extbase\Validate("StringLength", options={"minimum": 3})
     * @Extbase\Validate("StringLength", options={"maximum": 60})
     * @Extbase\Validate("NotEmpty")
     * @var string
     */
    protected $ratetable;

    /**
     * Fieldname within the table of the cObj
     * Defaults to the field 'uid'
     *
     * @Extbase\Validate("StringLength", options={"minimum": 3})
     * @Extbase\Validate("StringLength", options={"maximum": 60})
     * @Extbase\Validate("NotEmpty")
     * @var string
     */
    protected $ratefield;

    /**
     * The stepconfs of this object
     *
     * @Extbase\ORM\Lazy
     * @Extbase\ORM\Cascade("remove")
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf>
     */
    protected $stepconfs;

    /**
     * The ratings of this object
     *
     * @Extbase\ORM\Lazy
     * @Extbase\ORM\Cascade("remove")
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating>
     */
    protected $ratings;

    /**
     * @var \Thucke\ThRating\Domain\Repository\StepconfRepository
     */
    protected $stepconfRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\StepconfRepository $stepconfRepository
     */
    public function injectStepconfRepository(StepconfRepository $stepconfRepository)
    {
        $this->stepconfRepository = $stepconfRepository;
    }

    /**
     * @var  \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     */
    /** @noinspection PhpUnused */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService)
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Constructs a new rating object
     * @param string $ratetable The rating objects table name
     * @param string $ratefield The rating objects field name
     * @Extbase\Validate("StringLength", options={"minimum": 3}, param="ratetable")
     * @Extbase\Validate("StringLength", options={"maximum": 60}, param="ratetable")
     * @Extbase\Validate("StringLength", options={"minimum": 3}, param="ratefield")
     * @Extbase\Validate("StringLength", options={"maximum": 60}, param="ratefield")
     */
    public function __construct($ratetable = null, $ratefield = null)
    {
        if ($ratetable) {
            $this->setRatetable($ratetable);
        }
        if ($ratefield) {
            $this->setRatefield($ratefield);
        }
        $this->initializeObject();
    }

    /**
     * Initializes a new ratingobject
     */
    public function initializeObject()
    {
        //Initialize rating storage if ratingobject is new
        if (!is_object($this->ratings)) {
            /* @phpstan-ignore-next-line */
            $this->ratings = new ObjectStorage();
        }
        //Initialize stepconf storage if ratingobject is new
        if (!is_object($this->stepconfs)) {
            /* @phpstan-ignore-next-line */
            $this->stepconfs = new ObjectStorage();
        }
    }

    /**
     * Sets the rating table name
     *
     * @param string $ratetable
     */
    public function setRatetable($ratetable)
    {
        $this->ratetable = $ratetable;
    }

    /**
     * Gets the rating table name
     *
     * @return string Rating object table name
     */
    public function getRatetable()
    {
        return $this->ratetable;
    }

    /**
     * Sets the rating field name
     *
     * @param string $ratefield
     */
    public function setRatefield($ratefield)
    {
        $this->ratefield = $ratefield;
    }

    /**
     * Sets the rating field name
     *
     * @return string Rating object field name
     */
    public function getRatefield()
    {
        return $this->ratefield;
    }

    /**
     * Adds a rating to this object
     *
     * @param \Thucke\ThRating\Domain\Model\Rating $rating
     */
    /** @noinspection PhpUnused */
    public function addRating(Rating $rating)
    {
        $this->ratings->attach($rating);
        $this->extensionHelperService->persistRepository(RatingRepository::class, $rating);
        $this->extensionHelperService->clearDynamicCssFile();
    }

    /**
     * Remove a rating from this object
     *
     * @param \Thucke\ThRating\Domain\Model\Rating $rating The rating to be removed
     */
    public function removeRating(Rating $rating): void
    {
        $this->ratings->detach($rating);
    }

    /**
     * Remove all ratings from this object
     */
    public function removeAllRatings(): void
    {
        /* @phpstan-ignore-next-line */
        $this->ratings = new ObjectStorage();
    }

    /**
     * Adds a stepconf to this object
     *
     * @param \Thucke\ThRating\Domain\Model\Stepconf $stepconf
     */
    public function addStepconf(Stepconf $stepconf): void
    {
        if (!$this->stepconfRepository->existStepconf($stepconf)) {
            $this->stepconfs->attach($stepconf);
            $this->extensionHelperService->persistRepository(StepconfRepository::class, $stepconf);
            $this->extensionHelperService->clearDynamicCssFile();
        }
    }

    /**
     * Sets all ratings of this ratingobject
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf> $stepconfs
     *        The step configurations for this ratingobject
     */
    public function setStepconfs(ObjectStorage $stepconfs)
    {
        $this->stepconfs = $stepconfs;
    }

    /**
     * Returns all ratings in this object
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf>
     */
    public function getStepconfs()
    {
        return clone $this->stepconfs;
    }

    /**
     * Sets all ratings of this ratingobject
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating> $ratings
     *          The ratings of the organization
     */
    public function setRatings(ObjectStorage $ratings)
    {
        $this->ratings = $ratings;
    }

    /**
     * Returns all ratings in this object
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating>
     */
    public function getRatings()
    {
        return clone $this->ratings;
    }
}
