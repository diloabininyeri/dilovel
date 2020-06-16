<?php


namespace App\Components\Database;

/**
 * Class BuilderPaginate
 * @package App\Components\Database
 */
class BuilderPaginate
{

    /**
     * @var Paginate $paginate
     */
    private Paginate $paginate;

    /**
     * BuilderPaginate constructor.
     * @param Paginate $paginate
     */
    public function __construct(Paginate $paginate)
    {
        $this->paginate=$paginate;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return  $this->createNav().$this->createPaginateBody().'</ul></nav>';
    }

    /**
     * @return string
     */
    private function createPaginateBody(): string
    {
        $html = null;
        foreach ($this->createPagesRange(1, $this->paginate->maxPage()) as $page) {
            if ($page === $this->paginate->currentPage()) {
                $html .= sprintf('<li class="page-item active"><a class="page-link" href="?page=%d">%d</a></li>', $page, $page);
            } else {
                $html .= sprintf('<li class="page-item"><a class="page-link" href="?page=%d">%d</a></li>', $page, $page);
            }
        }
        return $html;
    }

    /**
     * @param int $currentPage
     * @param int $maxPage
     * @return array
     */
    private function createPagesRange(int $currentPage, int  $maxPage):array
    {
        return range($currentPage, $maxPage);
    }

    /**
     * @return string
     */
    private function createNav(): string
    {
        return '<nav aria-label="..."><ul class="pagination"><li class="page-item"><a class="page-link" href="?page=1">0</a></li>';
    }
}
