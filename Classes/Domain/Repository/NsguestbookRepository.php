<?php

namespace Nitsan\NsGuestbook\Domain\Repository;

/**
 * The repository for Nsguestbooks
 */
class NsguestbookRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * findSorted
     * @param mixed $settings
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findSorted($settings)
    {
        $query = $this->createQuery();
        if ($settings['sorting'] == 'DESCENDING') {
            $query->setOrderings(['crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING]);
        } else {
            $query->setOrderings(['crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING]);
        }
        $query = $query->execute();
        return $query;
    }
    
    public function countAll()
    {
        $query = $this->createQuery();
        return $query->execute()->count();
    }

    public function findByPage($offset, $limit)
    {
        $query = $this->createQuery();
        $query->setOffset($offset);
        $query->setLimit($limit);
        return $query->execute();
    }

}
