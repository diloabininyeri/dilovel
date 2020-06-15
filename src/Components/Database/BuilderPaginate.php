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
        return $this->createPaginate();
    }

    /**
     * @return string
     */
    private function createPaginateBody(): string
    {
        $maxPage = $this->paginate->maxPage();
        $currentPage = $this->paginate->currentPage();
        $lastPage = $currentPage + $this->paginate->perPage();
        if ($lastPage >= $maxPage) {
            $lastPage = $maxPage;
        }

        return $this->createList($currentPage, $lastPage);
    }

    /**
     * @param int $currentPage
     * @param int $lastPage
     * @return string|null
     */
    private function createList(int $currentPage, int $lastPage): ?string
    {
        $html = null;
        $pages=range($currentPage, $lastPage);
        foreach ($pages as $page) {
            if ($page === $currentPage) {
                $html .= sprintf('<li class="page-item active"><a class="page-link" href="?page=%d">%d</a></li>', $page, $page);
            } else {
                $html .= sprintf('<li class="page-item"><a class="page-link" href="?page=%d">%d</a></li>', $page, $page);
            }
        }
        return $html;
    }

    /**
     * @return string
     */
    private function createNav(): string
    {
        return '<nav aria-label="..."><ul class="pagination"><li class="page-item"><a class="page-link" href="?page=1">0</a></li>';
    }

    /**
     * @return string
     */
    private function createPaginate(): string
    {
        return  $this->createNav().$this->createPaginateBody().'</ul></nav>';
    }
}
