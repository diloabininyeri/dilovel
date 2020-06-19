<?php


namespace App\Components\Ml;

use Closure;
use JsonException;

/**
 * Class Bayes
 * @package App\Components\Ml
 * @link https://github.com/niiknow/bayes
 */
class TextCategorize
{
    /**
     * @var array
     */
    private array $STATE_KEYS = [
        'categories', 'docCount',
        'totalDocuments',
        'vocabulary', 'vocabularySize',
        'wordCount', 'wordFrequencyCount'
    ];

    /**
     * @var array
     */
    public array $categories;

    /**
     * @var array
     */
    private array $docCount;

    /**
     * @var int
     */
    private int $totalDocuments;

    /**
     * @var array
     */
    private array $vocabulary;

    /**
     * Vocabulary size
     *
     * @var int
     */
    private int  $vocabularySize;

    /**
     * for each category, how many words total were mapped to it
     *
     * @var int[]
     */
    private array $wordCount;

    /**
     * word frequency table for each category
     *  for each category, how frequent was a given word mapped to it
     *
     * @var integer[]
     */
    private array $wordFrequencyCount;

    /**
     * constructor options which include tokenizer
     *
     * @var array
     */
    protected ?array $options;

    /**
     * the tokenizer function
     *
     *
     */
    protected Closure $tokenizer;


    /**
     * Bayes constructor.
     * @param null $options
     */
    public function __construct($options = null)
    {
        $this->options = $options;
        $this->reset();
    }


    /**
     * @param $text
     * @return int|string|null
     */
    public function predict($text)
    {
        $that = $this;
        $maxProbability = -INF;
        $chosenCategory = null;

        if ($that->totalDocuments > 0) {
            $probabilities = $that->calculateProbabilities($text);
            foreach ($probabilities as $category => $logProbability) {
                if ($logProbability > $maxProbability) {
                    $maxProbability = $logProbability;
                    $chosenCategory = $category;
                }
            }
        }

        return $chosenCategory;
    }


    /**
     * @param $tokens
     * @return array
     */
    private function frequencyTable($tokens): array
    {
        $frequencyTable = [];
        foreach ($tokens as $token) {
            if (!isset($frequencyTable[$token])) {
                $frequencyTable[$token] = 1;
            } else {
                $frequencyTable[$token]++;
            }
        }

        return $frequencyTable;
    }


    /**
     * @param $json
     * @return $this
     * @throws JsonException
     *
     */
    public function fromJson($json):self
    {
        $result = $json;
        if (is_string($json)) {
            $result = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        $this->reset();
        foreach ($this->STATE_KEYS as $k) {
            if (isset($result[$k])) {
                $this->{$k} = $result[$k];
            }
        }

        return $this;
    }


    /**
     * @param $categoryName
     * @return $this
     */
    private function initializeCategory($categoryName): self
    {
        if (!isset($this->categories[$categoryName])) {
            $this->docCount[$categoryName] = 0;
            $this->wordCount[$categoryName] = 0;
            $this->wordFrequencyCount[$categoryName] = [];
            $this->categories[$categoryName] = true;
        }

        return $this;
    }


    /**
     * @param $text
     * @param $category
     * @return TextCategorize
     */
    public function learn($text, $category): TextCategorize
    {
        $that =$this;
        $that->initializeCategory($category);
        $that->docCount[$category]++;
        $that->totalDocuments++;
        $tokens = ($that->tokenizer)($text);
        $frequencyTable = $that->frequencyTable($tokens);
        foreach ($frequencyTable as $token => $frequencyInText) {
            if (!isset($that->vocabulary[$token])) {
                $that->vocabulary[$token] = true;
                $that->vocabularySize++;
            }

            if (!isset($that->wordFrequencyCount[$category][$token])) {
                $that->wordFrequencyCount[$category][$token] = $frequencyInText;
            } else {
                $that->wordFrequencyCount[$category][$token] += $frequencyInText;
            }

            $that->wordCount[$category] += $frequencyInText;
        }

        return $that;
    }

    /**
     * @param string $text
     * @return array
     */
    public function calculate(string $text):array
    {
        return $this->calculateProbabilities($text);
    }

    /**
     * @param $text
     * @return array
     */
    private function calculateProbabilities($text): array
    {
        $that = $this;
        $probabilities = [];

        if ($that->totalDocuments > 0) {
            $tokens = ($that->tokenizer)($text);
            $frequencyTable = $that->frequencyTable($tokens);

            foreach ($that->categories as $category => $value) {
                $categoryProbability = $that->docCount[$category] / $that->totalDocuments;
                $logProbability = log($categoryProbability);
                foreach ($frequencyTable as $token => $frequencyInText) {
                    $tokenProbability = $that->tokenProbability($token, $category);

                    $logProbability += $frequencyInText * log($tokenProbability);
                }

                $probabilities[$category] = $logProbability;
            }
        }

        return $probabilities;
    }


    /**
     * @return $this
     */
    public function reset(): self
    {
        $this->options??=[];

        $this->tokenizer = $this->options['tokenizer'] ?? function ($text) {
            $text = mb_strtolower($text);
            preg_match_all('/[[:alpha:]]+/u', $text, $matches);
            return $matches[0];
        };

        $this->categories = [];
        $this->docCount = [];
        $this->totalDocuments = 0;
        $this->vocabulary = [];
        $this->vocabularySize = 0;
        $this->wordCount = [];
        $this->wordFrequencyCount = [];

        return $this;
    }

    /**
     * @return false|string
     * @throws JsonException
     */
    public function toJson()
    {
        $result = [];
        foreach ($this->STATE_KEYS as $k) {
            $result[$k] = $this->{$k};
        }

        return json_encode($result, JSON_THROW_ON_ERROR);
    }

    /**
     * @param $token
     * @param $category
     * @return float|int
     */
    public function tokenProbability($token, $category)
    {
        $wordFrequencyCount = $this->wordFrequencyCount[$category][$token] ?? 0;
        $wordCount = $this->wordCount[$category];

        return ($wordFrequencyCount + 1) / ($wordCount + $this->vocabularySize);
    }
}
