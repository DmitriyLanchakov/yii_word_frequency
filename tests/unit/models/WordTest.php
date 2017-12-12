<?php

namespace tests\models;

use app\models\Word;

class WordTest extends \Codeception\Test\Unit
{
    public function testCountWords()
    {
        $input           = "n der! №Buh dog dog cat 522 Ёф es Abt";
        $output_original = "n - 1<br>der - 1<br>buh - 1<br>dog - 2<br>cat - 1<br>es - 1<br>abt - 1<br>";

        $word   = new Word();
        $output = $word->countWords($input);

        expect($output)->equals($output_original);
    }
}
