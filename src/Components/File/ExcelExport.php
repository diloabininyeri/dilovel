<?php


namespace App\Components\File;

use phpDocumentor\Reflection\Types\This;

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
     * @param array $labels
     */
    public function __construct(array $data, string $name)
    {
        $this->data = $data;
        $this->name = $name;
    }
    /**
     * @param array $keys
     * @return $this
     */
    public function only(array $keys):self
    {
        $this->data= array_map(static function ($item) use ($keys) {
            $return=[];
            foreach ($keys as $key) {
                $return[$key]=$item[$key];
            }
            return $return;
        }, $this->data);
        return $this;
    }

    /**
     * @param callable $closure
     * @return $this
     */
    public function filter(callable $closure):self
    {
        $this->data=array_filter($this->data, $closure);
        return $this;
    }
    /**
     * @param array $labels
     * @return $this
     */
    public function setLabels(array $labels):self
    {
        $this->labels=$labels;
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
        $header = '<tr>';
        foreach ($this->getLabels() as $key => $value) {
            $header .= "<th>$value</th>";
        }
        $header .= '</tr>';
        return $header;
    }

    /**
     * @return string
     */
    private function createTdElements():string
    {
        $html = null;
        foreach ($this->data as $iValue) {
            $html .= '<tr>';
            foreach ($iValue as $key => $value) {
                $html .= "<td>$value</td>";
            }
            $html .= '</tr>';
        }
        return  $html;
    }

    /**
     * @return string
     */
    public function createHtmlWithTable(): string
    {
        return sprintf(
            '  <meta charset="%s"><table>%s%s</table>',
            $this->charset,
            $this->createThElements(),
            $this->createTdElements()
        );
    }


    /**
     * @return bool
     */
    public function download(): bool
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $this->name . '"');
        header('Cache-Control: max-age=0');
        $output = fopen('php://output', 'wb');
        fwrite($output, $this->createHtmlWithTable());
        return fclose($output);
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
        $this->name = $name.'.xlsx';
        return $this;
    }
}
