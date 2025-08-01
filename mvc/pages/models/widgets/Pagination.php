<?php
namespace Haskris\Hub\Models\Widgets;

use Haskris\Hub\Views\Data;
use Haskris\Hub\Views\Collection as ViewsCollection;
use Haskris\Base\Models\Widgets\Pagination as Base;

class Pagination
{
    use Base;
    public const PAGE_LIMIT = 25;
    private const TMPL_DIR = 'widgets/pagination/';

    public function buildPagination(
        int $recordCount,
        int $currentPage
    ): Data {

        $buttonList = new ViewsCollection();
        
        $data = $this->getPaginationData(
            $recordCount,
            $currentPage,
            self::PAGE_LIMIT
        );

        $prev  = $data['prev'];
        $links = $data['links'];
        $next  = $data['next'];

        //Add Prev button
        $buttonList->append(
            new Data(self::TMPL_DIR . 'button.php', [
                'classList'     => ($prev->disabled ? ' disabled' : ''),
                'title'         => $prev->title,
                'active'        => !$prev->disabled,
                'text'          => 'PREV',
                'mobileText'    => '<',
                'pageNumber'    => $prev->pageNumber
            ])
        );

        //Add individual page buttons
        foreach ($links as $link) {
            $buttonList->append(
                new Data(self::TMPL_DIR . 'button.php', [
                    'classList'     => ($link->active ? ' current' : ''),
                    'title'         => $link->title,
                    'active'        => !$link->active,
                    'text'          => $link->text,
                    'mobileText'    => $link->text,
                    'pageNumber'    => $link->pageNumber
                ])
            );
        }

        //Add Next button
        $buttonList->append(
            new Data(self::TMPL_DIR . 'button.php', [
                'classList'   => ($next->disabled ? ' disabled' : ''),
                'title'       => $next->title,
                'active'      => !$next->disabled,
                'text'        => 'NEXT',
                'mobileText'  => '>',
                'pageNumber'  => $next->pageNumber
            ])
        );

        //Return list
        return new Data(self::TMPL_DIR . 'list.php', [
            'buttonList' => $buttonList
        ]);
    }
}