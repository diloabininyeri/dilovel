<?php


namespace App\Components\Database;

use App\Components\Http\Url;

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
     * @var array|null $uriQueries
     */
    private ?array $uriQueries=[];

    /**
     * BuilderPaginate constructor.
     * @param Paginate $paginate
     */
    public function __construct(Paginate $paginate)
    {
        $this->paginate = $paginate;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->createNav() . $this->createPaginateBody() . '</ul></nav>';
    }

    /**
     * @param array $query
     * @return $this
     */
    public function append(array $query):self
    {
        $this->uriQueries=$query;
        return  $this;
    }

    /**
     * @return string
     */
    private function currentUrlWithoutQueries(): string
    {
        return (new Url())->withoutQueries();
    }

    /**
     * @return string
     * @noinspection HtmlUnknownTarget
     *
     */
    private function createPaginateBody(): string
    {
        $html = null;
        $uri = $this->currentUrlWithoutQueries();

        foreach ($this->createPagesRange(1, $this->paginate->maxPage()) as $page) {
            if ($page === $this->paginate->currentPage()) {
                $html .= sprintf(
                    '<li class="page-item active"><a class="page-link" href="%s?page=%d&%s">%d</a></li>',
                    $uri,
                    $page,
                    http_build_query($this->uriQueries),
                    $page
                );
            } else {
                $html .= sprintf(
                    '<li class="page-item"><a class="page-link" href="%s?page=%d&%s">%d</a></li>',
                    $uri,
                    $page,
                    http_build_query($this->uriQueries),
                    $page
                );
            }
        }
        return $html;
    }

    /**
     * @param int $currentPage
     * @param int $maxPage
     * @return array
     */
    private function createPagesRange(int $currentPage, int $maxPage): array
    {
        $this->uriQueries;
        return range($currentPage, $maxPage);
    }

    /**
     * @return string
     */
    private function createNav(): string
    {
        return '<nav aria-label="..."><ul class="pagination"><li class="page-item"><a class="page-link" href="?page=1">0</a></li>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
