<?php


namespace App\Components\Database;

use App\Components\Collection\Collection;
use App\Components\Http\Request;
use IteratorAggregate;
use JsonException;
use Traversable;

/**
 * Class Paginate
 * @package App\Components\Database
 */
class Paginate implements IteratorAggregate
{
    /**
     * @var Collection
     */
    private Collection $data;
    /**
     * @var int
     */
    private int $count;
    /**
     * @var int
     */
    private int $perPage;
    /**
     * @var Request
     */
    private Request $request;

    /**
     * Paginate constructor.
     * @param Collection $data
     * @param int $count
     * @param int $perPage
     */
    public function __construct(Collection $data, int $count, int $perPage)
    {
        $this->data = $data;
        $this->count = $count;
        $this->perPage = $perPage;
        $this->request = new Request();
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
        $maxPage = $this->maxPage();
        $currentPage = $this->currentPage();

        $lastPage = $currentPage + $this->perPage;
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
        return '<nav aria-label="...">
                <ul class="pagination">
                  <li class="page-item">
                   <a class="page-link" href="?page=1">0</a>
              </li>';
    }

    /**
     * @return string
     */
    private function createPaginate(): string
    {
        $html = $this->createNav();
        $html .= $this->createPaginateBody();
        $html .= '</ul></nav>';
        return $html;
    }

    /**
     * @return int
     */
    private function maxPage(): int
    {
        return ceil($this->count / $this->perPage);
    }

    /**
     * @return int
     */
    public function currentPage(): int
    {
        if ($this->request->get('page')>$this->maxPage()) {
            return $this->maxPage();
        }
        return (int)$this->request->get('page') ?: 1;
    }

    /**
     * @return Collection|Traversable
     */
    public function getIterator()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function __debugInfo(): array
    {
        return iterator_to_array($this->data);
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function __toString(): string
    {
        return (string)$this->data->toJson();
    }
}
