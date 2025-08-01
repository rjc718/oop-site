<?php
namespace Haskris\Base\Models\Widgets;

trait Pagination
{
    protected int $limit = 25;
    protected int $currentPage = 1;

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function setCurrentPage(int $page): void
    {
        $this->currentPage = max(1, $page);
    }

    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->limit;
    }

    public function getPaginationData(
        int $totalRecords,
        int $currentPage,
        int $pageLimit
    ): array 
    {
        $this->setCurrentPage($currentPage);
        $this->setLimit($pageLimit);

        $totalPages = (int) ceil($totalRecords / $this->limit);
        $this->currentPage = max(1, min($this->currentPage, $totalPages));

        $addPage = fn(int $page, bool $active = false) => (object)[
            'text'       => (string) $page,
            'active'     => $active,
            'pageNumber' => $page,
            'title'      => "Page $page of $totalPages"
        ];

        $addJump = function (int $targetPage, bool $forward = true) {
            return (object)[
                'text'       => '...',
                'active'     => false,
                'jumpTo'     => $targetPage,
                'pageNumber' => $targetPage,
                'title'      => $forward ? 'Next 3 Pages' : 'Previous 3 Pages'
            ];
        };

        $links = [];

        $links[] = $addPage(1, $this->currentPage === 1);

        if ($totalPages <= 6) {
            for ($i = 2; $i <= $totalPages; $i++) {
                $links[] = $addPage($i, $this->currentPage === $i);
            }
        } else {
            if ($this->currentPage <= 3) {
                for ($i = 2; $i <= 3; $i++) {
                    $links[] = $addPage($i, $this->currentPage === $i);
                }
                $links[] = $addJump(4, true);
            } elseif ($this->currentPage >= $totalPages - 2) {
                $links[] = $addJump($this->currentPage - 3, false);
                $start = max(2, $totalPages - 2);
                for ($i = $start; $i < $totalPages; $i++) {
                    $links[] = $addPage($i, $this->currentPage === $i);
                }
            } else {
                $links[] = $addJump($this->currentPage - 3, false);
                $links[] = $addPage($this->currentPage, true);
                $links[] = $addJump($this->currentPage + 3, true);
            }

            // Always add last page if not already included
            if (!in_array($totalPages, array_column($links, 'pageNumber'))) {
                $links[] = $addPage($totalPages, $this->currentPage === $totalPages);
            }
        }

        return [
            'prev' => (object)[
                'disabled'   => $this->currentPage <= 1,
                'pageNumber' => $this->currentPage - 1,
                'title'      => 'Previous Page'
            ],
            'links' => $links,
            'next' => (object)[
                'disabled'   => $this->currentPage >= $totalPages,
                'pageNumber' => $this->currentPage + 1,
                'title'      => 'Next Page'
            ]
        ];
    }

    public function divideRecordsIntoPages(array $data, int $limit): array
    {
        if ($limit <= 0) {
            return []; 
        }

        return array_chunk($data, $limit);
    }

    public function getRecordsForPage(array $data, int $pageNumber): array
    {
        $index = $pageNumber - 1;

        if ($index < 0 || $index >= count($data)) {
            return []; 
        }
        return $data[$index];
    }

    public function getRecordRange(int $totalRecords): array
    {
        if ($totalRecords === 0) {
            return [0, 0];
        }

        $start = ($this->currentPage - 1) * $this->limit + 1;
        $end = min($this->currentPage * $this->limit, $totalRecords);

        return [$start, $end];
    }

}
