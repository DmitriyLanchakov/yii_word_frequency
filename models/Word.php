<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

/**
 * Word model
 *
 * @property integer $id
 * @property string $input
 * @property string $output
 */
class Word extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%word}}';
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Set input
     *
     * @param string $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

    /**
     * Get input
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set output
     *
     * @param string $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Get output
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Get total string.
     *
     * @return string
     */
    public function countWords($string)
    {
        $string = str_split($string);
        $filtered_string = '';
        foreach ($string as $s) {
            if (preg_match('/[a-zA-Z\s]/', $s, $matches, PREG_OFFSET_CAPTURE)) {
                $filtered_string = $filtered_string . strtolower($s);
            }
        }

        $words = preg_split('/\s+/', $filtered_string);

        foreach ($words as $word) {
            if (!empty($word)) {
                $filtered_words[] = $word;
            }
        }

        $counted_words = array_count_values($filtered_words);
        $total_string = '';

        foreach ($counted_words as $word => $amount) {
            $total_string = $total_string . $word . ' - ' . $amount . '<br>';
        }

        return $total_string;
    }

}