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
     * @var BuilderPaginate $builderPaginate
     */
    private BuilderPaginate $builderPaginate;

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
        $this->request = Request::getInstance();
        $this->builderPaginate = new BuilderPaginate($this);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->builderPaginate->render();
    }

    /**
     * @param array $query
     * @return BuilderPaginate
     */
    public function append(array $query): BuilderPaginate
    {
        return $this->builderPaginate->append($query);
    }

    /**
     * @return int
     */
    public function perPage():int
    {
        return $this->perPage;
    }
    /**
     * @return int
     */
    public function maxPage(): int
    {
        return ceil($this->count / $this->perPage);
    }

    /**
     * @return int
     */
    public function currentPage(): int
    {
        if ($this->request->get('page') > $this->maxPage()) {
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
