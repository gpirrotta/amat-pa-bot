<?php

/**
 * This file is part of the AmatPABot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\AmatPABot\Command;

use GP\AmatPABot\Repository\GTFSRepositoryInterface;
use GP\AmatPABot\Command\GTFSCommand;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
abstract class GTFSCommandRepositoryAware extends GTFSCommand
{
    protected $repository;

    public function __construct(GTFSRepositoryInterface $repository = null)
    {
        $this->repository = $repository;
    }

}
