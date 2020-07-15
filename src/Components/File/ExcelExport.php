<?php


namespace App\Components\File;

/**
 * Class ExcelExport
 * @package App\Components\File
 */
class ExcelExport
{
    /**
     * @var array
     */
    private array $data;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var array
     */
    private array $labels;

    /**
     * @var string
     */
    private string  $charset = 'UTF-8';


    /**
     * ExcelExport constructor.
     * @param array $data
     * @param string $name
     */
    public function __construct(array $data, string $name)
    {
        $this->data = $data;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @param array $keys
     * @return $this
     */
    public function except(array $keys): self
    {
        return $this->only(array_diff($this->getLabels(), $keys));
    }

    /**
     * @param array $keys
     * @return $this
     */
    public function only(array $keys): self
    {
        $this->data = array_map(static function ($item) use ($keys) {
            $return = [];
            foreach ($keys as $key) {
                $return[$key] = $item[$key];
            }
            return $return;
        }, $this->data);
        return $this;
    }

    /**
     * @param callable $closure
     * @return $this
     */
    public function filter(callable $closure): self
    {
        $this->data = array_values(array_filter($this->data, $closure));
        return $this;
    }

    /**
     * @param callable $closure
     * @return $this
     */
    public function each(callable $closure): self
    {
        array_walk($this->data, $closure);
        return $this;
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function map(callable $callable):self
    {
        $this->data= array_map($callable, $this->data);
        return  $this;
    }

    /**
     * @param array $labels
     * @return $this
     */
    public function setLabels(array $labels): self
    {
        $this->labels = $labels;
        return $this;
    }

    /**
     * @return array
     */
    private function getLabels(): array
    {
        return $this->labels ?? array_keys($this->data[0]);
    }

    /**
     * @return string
     */
    private function createThElements(): string
    {
        $header = '<thead><tr>';
        foreach ($this->getLabels() as $key => $value) {
            $header .= "<th>$value</th>";
        }
        $header .= '</tr></thead>';
        return $header;
    }

    /**
     * @return string
     */
    private function createTdElements(): string
    {
        $html = '<tbody>';
        foreach ($this->data as $iValue) {
            $html .= '<tr>';
            foreach ($iValue as $key => $value) {
                $html .= "<td>$value</td>";
            }
            $html .= '</tr>';
        }
        $html.='</tbody>';
        return $html;
    }

    /**
     * @return string
     */
    public function toHtml(): ?string
    {
        $open = fopen('php://output', 'wb');
        fwrite($open, $this->importCss());
        fwrite($open, $this->getHtmlContent());
        return fclose($open);
    }

    /**
     * @return string
     * @noinspection HtmlUnknownTarget
     */
    private function importCss():string
    {
        return sprintf('<link rel="stylesheet" href="%s">', assets('css/excel.table.css'));
    }

    /**
     * @return string|null
     */
    private function getHtmlContent():?string
    {
        if ($this->isMulti()) {
            return sprintf(
                '  <meta charset="%s"><table>%s%s</table>',
                $this->charset,
                $this->createThElements(),
                $this->createTdElements()
            );
        }
        return null;
    }

    /**
     * @return bool
     */
    private function isMulti():bool
    {
        $check = array_filter($this->data, 'is_array');
        return (count($check) > 0);
    }

    /**
     * @return bool
     */
    public function download(): bool
    {
        if ($this->isMulti()) {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $this->name . '"');
            header('Cache-Control: max-age=0');
            $output = fopen('php://output', 'wb');
            fwrite($output, $this->getHtmlContent());
            return fclose($output);
        }
        return false;
    }

    /**
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escapeChar
     * @return false|string
     */
    public function downloadAsCsv($delimiter = ',', $enclosure = '"', $escapeChar = "\\")
    {
        if ($this->isMulti()) {
            $file = fopen('php://memory', 'rb+');
            foreach ($this->data as $item) {
                fputcsv($file, $item, $delimiter, $enclosure, $escapeChar);
            }
            rewind($file);
            header('content-type:text/csv');
            header('Content-Disposition: attachment; filename="' . str_replace('.xlsx', '.csv', $this->name) . '";');
            return stream_get_contents($file);
        }
        return  false;
    }

    /**
     * @param string $charset
     * @return ExcelExport
     */
    public function setCharset(string $charset): ExcelExport
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * @param string $name
     * @return ExcelExport
     */
    public function setName(string $name): ExcelExport
    {
        $this->name = $name . '.xlsx';
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return string|null
     */
    public function toArrayString():string
    {
        return var_export($this->toArray(), true);
    }

    /**
     * @param int $offset
     * @param null $length
     * @return $this
     */
    public function slice(int $offset, $length=null):self
    {
        $this->data=array_slice($this->data, $offset, $length);
        return $this;
    }

    /**
     * @param string ...$indexNames
     * @return $this
     */
    public function unique(string ...$indexNames):self
    {
        foreach ($indexNames as $indexName) {
            $this->data=array_uunique($this->data, fn ($i, $k) =>$i[$indexName]<=>$k[$indexName]);
        }
        return $this;
    }

    public function inspect(): void
    {
        dd($this->data);
    }

    /**
     * @param array $default
     * @return $this
     */
    public function withDefault(array $default):self
    {
        array_walk($this->data, static function (&$item) use ($default) {
            foreach ($default as $key => $value) {
                if ($item[$key] === null) {
                    $item[$key]=$value;
                }
            }
        });

        return $this;
    }

    /**
     * @param string $key
     * @param callable $closure
     * @return $this
     */
    public function setValue(string $key, callable $closure):self
    {
        array_walk($this->data, fn (&$i) =>$i[$key]=$closure($i[$key]));
        return  $this;
    }

    /**
     * @param array $labels
     * @param string $separator
     * @return $this
     */
    public function joinLabel(array $labels, string $separator=' '):self
    {
        return $this->map(static function ($item) use ($labels,$separator) {
            $valueJoin=[];
            foreach ($labels as $label) {
                $valueJoin[]=$item[$label];
                unset($item[$label]);
            }

            $item[implode(' ', $labels)]=implode($separator, $valueJoin);
            return $item;
        });
    }

    /**
     * @return false|string
     * @throws \JsonException
     */
    public function toJson()
    {
        header('Content-type:application/json');
        return json_encode($this->data, JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR);
    }
}
